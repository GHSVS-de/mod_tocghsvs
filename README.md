# mod_tocghsvs
- Joomla module. Automatically creates a table of contents on the current page. Links/anchors as list that jump to bookmarks, e.g. headings.
- JavaScript based upon a **very old** version of [paypal/skipto](https://github.com/paypal/skipto)

## Be aware
- **Out of the can only suitable for tinkerers and play children.**
- Designed for ghsvs.de Bootstrap 5 templates.
- Needs custom CSS and JS if sticky containers on page. Not included.

-----------------------------------------------------

# My personal build procedure (WSL 1, Debian, Win 10)

**@since v2022.06.22: Build procedure uses local repo fork of https://github.com/GHSVS-de/buildKramGhsvs**

- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/mod_tocghsvs`

## node/npm updates/installation
- `npm run updateCheck`
- `npm run update`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
  - See release description in `dist/release_no-changelog.txt`.
- Extracts of the update XML for update servers are in `./dist` as well. Copy/paste and necessary additions.
