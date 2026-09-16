#!/usr/bin/env node
/* eslint-disable no-console -- CLI progress for npm run test:smoke */
/**
 * Smoke test: boot WordPress Playground with this theme active, visit the
 * main templates, and fail on PHP errors, browser console errors, a missing
 * theme stylesheet, or an unexpected HTTP status.
 *
 * Usage:
 *   npm run test:smoke
 *
 * Requires network access the first time (Playground downloads WordPress).
 */

const { spawn } = require("child_process");
const fs = require("fs");
const os = require("os");
const path = require("path");
const puppeteer = require("puppeteer");

const PORT = 9410;
const BASE = `http://127.0.0.1:${PORT}`;
const ROOT = path.resolve(__dirname, "..");
const BOOT_TIMEOUT_MS = 5 * 60 * 1000;

const PAGES = [
	{ name: "home", url: "/", status: 200 },
	{ name: "single", url: "/hello-world/", status: 200 },
	{ name: "page", url: "/sample-page/", status: 200 },
	{ name: "search", url: "/?s=hello", status: 200 },
	{ name: "404", url: "/this-page-does-not-exist/", status: 404 },
];

// Console errors that come from the environment rather than the theme.
const IGNORED_CONSOLE = [/favicon\.ico/];

const blueprint = {
	landingPage: "/",
	steps: [
		{ step: "setSiteOptions", options: { permalink_structure: "/%postname%/" } },
		{ step: "activateTheme", themeFolderName: "tendo" },
		// Pretty permalinks need rewrite rules, or every path serves the home page.
		{ step: "runPHP", code: "<?php require '/wordpress/wp-load.php'; flush_rewrite_rules();" },
	],
};

function bootPlayground() {
	const blueprintPath = path.join(os.tmpdir(), `tendo-smoke-${process.pid}.json`);
	fs.writeFileSync(blueprintPath, JSON.stringify(blueprint));

	const child = spawn(
		"npx",
		[
			"-y",
			"@wp-playground/cli@latest",
			"server",
			"--wp=latest",
			"--php=8.3",
			`--port=${PORT}`,
			`--mount=${ROOT}:/wordpress/wp-content/themes/tendo`,
			`--blueprint=${blueprintPath}`,
		],
		{ stdio: ["ignore", "pipe", "pipe"] }
	);

	const ready = new Promise((resolve, reject) => {
		const timer = setTimeout(
			() => reject(new Error("Playground did not boot in time")),
			BOOT_TIMEOUT_MS
		);
		let output = "";
		const onData = (chunk) => {
			output += chunk.toString();
			if (output.includes("Ready!")) {
				clearTimeout(timer);
				resolve();
			}
		};
		child.stdout.on("data", onData);
		child.stderr.on("data", onData);
		child.on("exit", (code) => {
			clearTimeout(timer);
			reject(new Error(`Playground exited with code ${code}\n${output.slice(-2000)}`));
		});
	});

	return { child, ready, blueprintPath };
}

async function run() {
	const failures = [];
	const { child, ready, blueprintPath } = bootPlayground();

	try {
		console.log("Booting WordPress Playground…");
		await ready;
		console.log(`Playground ready at ${BASE}`);

		const browser = await puppeteer.launch({
			args: process.env.CI ? ["--no-sandbox", "--disable-setuid-sandbox"] : [],
		});
		const page = await browser.newPage();
		await page.setViewport({ width: 1200, height: 900 });

		for (const test of PAGES) {
			const consoleErrors = [];
			const onConsole = (message) => {
				if (message.type() !== "error") {
					return;
				}
				const text = message.text();
				// A 404 template legitimately logs its own document request as a failed resource.
				const ownNotFound = test.status === 404 && /status of 404/.test(text);
				if (!ownNotFound && !IGNORED_CONSOLE.some((pattern) => pattern.test(text))) {
					consoleErrors.push(text);
				}
			};
			const onPageError = (error) => consoleErrors.push(`Uncaught: ${error.message}`);
			page.on("console", onConsole);
			page.on("pageerror", onPageError);

			const response = await page.goto(BASE + test.url, { waitUntil: "networkidle2" });
			const status = response ? response.status() : 0;
			const html = await page.content();
			const bodyText = await page.evaluate(() => document.body.innerText);

			page.off("console", onConsole);
			page.off("pageerror", onPageError);

			const problems = [];
			if (status !== test.status) {
				problems.push(`expected HTTP ${test.status}, got ${status}`);
			}
			if (!html.includes("tendo-style-css")) {
				problems.push("theme stylesheet is not enqueued (is dist/ built?)");
			}
			if (/Fatal error|Warning: |Notice: |Deprecated: /.test(bodyText)) {
				problems.push("PHP error text appears in the page");
			}
			if (consoleErrors.length) {
				problems.push(`console errors: ${consoleErrors.join(" | ")}`);
			}

			if (problems.length) {
				failures.push(`${test.name} (${test.url}): ${problems.join("; ")}`);
				console.log(`✖ ${test.name}`);
			} else {
				console.log(`✔ ${test.name}`);
			}
		}

		await browser.close();
	} finally {
		child.kill("SIGTERM");
		fs.rmSync(blueprintPath, { force: true });
	}

	if (failures.length) {
		console.error("\nSmoke test failed:\n- " + failures.join("\n- "));
		process.exit(1);
	}
	console.log("\nAll templates rendered cleanly.");
}

run().catch((error) => {
	console.error(error.message);
	process.exit(1);
});
