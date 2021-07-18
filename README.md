# mod_tocghsvs
- Joomla module. Automatically creates a table of contents on the current page. Links/anchors as list that jump to bookmarks, e.g. headings.
- Designed for ghsvs.de Bootstrap 5 templates.
- Needs custom CSS and JS if sticky containers on page. Not included.
- **Out of the can only suitable for tinkerers and play children.**
- JavaScript based upon a **very old** version of [paypal/skipto](https://github.com/paypal/skipto)

## My private build procedure on WSL1, Win10, Debian
- Prepare/adapt `./package.json`.
- Put custom Joomla `/media/` files into `./media` folder as usual. Will be installed in `/media/mod_tocghsvs/` as usual.
- Put other files into `./src`. Don't forget to customise `./src/mod_tocghsvs.xml` if new files and folders added.
- `cd /mnt/z/git-kram/mod_tocghsvs`
- `npm run g-npm-update-check` or (faster) `ncu`
- `npm run g-ncu-override-json` (if needed) or (faster) `ncu -u`
- `npm install` (if needed)
- `npm run g-build` or (faster) `node build.js`
- Installable ZIP is in `./dist` afterwards.
- FYI: Packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.
