const fse = require('fs-extra');
const util = require("util");
const rimRaf = util.promisify(require("rimraf"));
const chalk = require('chalk');
const path = require('path');

const {
	author,
	creationDate,
	copyright,
	filename,
	name,
	version,
	licenseLong,
	minimumPhp,
	maximumPhp,
	minimumJoomla,
	maximumJoomla,
	allowDowngrades,
} = require("./package.json");

const Manifest = `${__dirname}/package/${name}.xml`;

// Joomla media folder (target workdir) inside this project. For copy-to actions.
const pathMedia = `./media`;

// Subdirectory for copy-to actions.
const pathMediaTarget = `vendor/swiper`;

async function copyFiles (source, target) {
  try {
    await fse.copySync(source, target)
    console.log(chalk.yellowBright(`Copied ${path.basename(target)}`))
  } catch (err) {
    console.error(err)
  }
}

async function cleanOut (cleanOuts) {
	for (const file of cleanOuts)
	{
		await rimRaf(file).then(
			answer => console.log(chalk.redBright(`rimrafed: ${file}.`))
		).catch(error => console.log(error));
	}
}

(async function exec()
{
	let cleanOuts = [
		`./package`,
		`./dist`,
	];

	await cleanOut(cleanOuts);

	for (const file of cleanOuts)
	{
		await fse.mkdirs(file
		).then(
			answer => console.log(chalk.greenBright(`Created empty ${file}`))
		);
	}

	await fse.copy(`${pathMedia}`, `./package/media`
	).then(
		answer => console.log(chalk.greenBright(`Copied ${pathMedia} to ./package.`))
	);

	await fse.copy("./src", "./package"
	).then(
		answer => console.log(chalk.greenBright(`Copied ./src to ./package.`))
	);

	// ### Build manifest XML file
	let xml = await fse.readFile(Manifest, { encoding: "utf8" });
	xml = xml.replace(/{{name}}/g, name);
	xml = xml.replace(/{{nameUpper}}/g, name.toUpperCase());
	xml = xml.replace(/{{authorName}}/g, author.name);
	xml = xml.replace(/{{creationDate}}/g, creationDate);
	xml = xml.replace(/{{copyright}}/g, copyright);
	xml = xml.replace(/{{licenseLong}}/g, licenseLong);
	xml = xml.replace(/{{authorUrl}}/g, author.url);
	xml = xml.replace(/{{version}}/g, version);
	xml = xml.replace(/{{minimumPhp}}/g, minimumPhp);
	xml = xml.replace(/{{maximumPhp}}/g, maximumPhp);
	xml = xml.replace(/{{minimumJoomla}}/g, minimumJoomla);
	xml = xml.replace(/{{maximumJoomla}}/g, maximumJoomla);
	xml = xml.replace(/{{allowDowngrades}}/g, allowDowngrades);
	xml = xml.replace(/{{filename}}/g, filename);

	await fse.writeFile(Manifest, xml, { encoding: "utf8" }
	).then(
		answer => console.log(chalk.yellowBright(`Replaced entries in ${Manifest}.`))
	);
	// ### Build manifest XML file - END

	// Zip it
	const zipFilename = `${name}-${version}.zip`;
	const zip = new (require("adm-zip"))();
	zip.addLocalFolder("package", false);
	await zip.writeZip(`dist/${zipFilename}`);
	console.log(chalk.cyanBright(chalk.bgRed(
		`./dist/${zipFilename} written.`)));

	cleanOuts = [
		`./package`,
	];

	await cleanOut(cleanOuts).then(
		answer => console.log(chalk.cyanBright(chalk.bgRed(
			`Finished. Good bye!`)))
	);
})();
