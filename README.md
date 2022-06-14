# mod_tocghsvs
- Joomla module. Automatically creates a table of contents on the current page. Links/anchors as list that jump to bookmarks, e.g. headings.
- JavaScript based upon a **very old** version of [paypal/skipto](https://github.com/paypal/skipto)

## Be aware
- **Out of the can only suitable for tinkerers and play children.**
- Designed for ghsvs.de Bootstrap 5 templates.
- Needs custom CSS and JS if sticky containers on page. Not included.

-----------------------------------------------------

# My personal build procedure (WSL 1, Debian, Win 10)
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/mod_tocghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## PHP Codestyle
If you think it's worth it.
- `cd /mnt/z/git-kram/php-cs-fixer-ghsvs`
- `npm run mod_tocghsvsDry` (= dry test run).
- `npm run mod_tocghsvs` (= cleans code).
- `cd /mnt/z/git-kram/mod_tocghsvs` (back to this repo).

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
- - See release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and necessary additions.
