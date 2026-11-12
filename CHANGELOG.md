# [0.5.0](https://github.com/99linesofcode/laravel-skeleton/compare/v0.4.1...v0.5.0) (2026-11-12)


### Features

* **users:** sign users in through laravel-module-user's auth model ([db90d33](https://github.com/99linesofcode/laravel-skeleton/commit/db90d338313b4b7f7c7b88c1315d8531e926948a))



## [0.4.1](https://github.com/99linesofcode/laravel-skeleton/compare/v0.4.0...v0.4.1) (2026-11-12)


### Bug Fixes

* **arch:** open only laravel-module-support's shared kernel and Lib ([c84da59](https://github.com/99linesofcode/laravel-skeleton/commit/c84da591c030bd1fd532d5a2fa21483147934e5b))



# [0.4.0](https://github.com/99linesofcode/laravel-skeleton/compare/v0.3.1...v0.4.0) (2026-11-12)


### Bug Fixes

* alphabetical order ([7d8e91a](https://github.com/99linesofcode/laravel-skeleton/commit/7d8e91ab66d0e8cba4e24394f6340109fbce024e))
* cookies are not available for subdomains by default ([#6705](https://github.com/99linesofcode/laravel-skeleton/issues/6705)) ([f6b2e79](https://github.com/99linesofcode/laravel-skeleton/commit/f6b2e79bdbfc5bf4a37ad16466cc06ad79cc9e8f))
* ensure APP_URL does not have trailing slash in filesystem public URL ([#6728](https://github.com/99linesofcode/laravel-skeleton/issues/6728)) ([591d3e8](https://github.com/99linesofcode/laravel-skeleton/commit/591d3e89030a5b6cb1ca479f4ecead3d87f03895))


### Features

* add type hints for $this in routes/console.php ([#6559](https://github.com/99linesofcode/laravel-skeleton/issues/6559)) ([1390672](https://github.com/99linesofcode/laravel-skeleton/commit/139067230229d16805cf5bd865acb8a9b59ab6b9))
* **arch:** hold both roots and the package boundary in the arch test ([2664d93](https://github.com/99linesofcode/laravel-skeleton/commit/2664d939a45d6102641fb93d8f08cb17c309c9a8))
* let the framework find factories, policies and listeners under src/ ([a23e8ff](https://github.com/99linesofcode/laravel-skeleton/commit/a23e8ffb6f7d294659daf9eb39c82b8c77ece841))
* make the skeleton a complete, runnable Laravel app ([8d19f22](https://github.com/99linesofcode/laravel-skeleton/commit/8d19f22eb6b50b5a548a584afb3613783de2439d))
* Remove unnecessary link type ([e40dfc6](https://github.com/99linesofcode/laravel-skeleton/commit/e40dfc6b4d1e8f0e3994471b583e821f3a0710d8))


### Reverts

* Revert "add index to failed jobs" (#6739) ([e713de2](https://github.com/99linesofcode/laravel-skeleton/commit/e713de24b883712cbb7fbc12d9b3aa1460e28cb7)), closes [#6739](https://github.com/99linesofcode/laravel-skeleton/issues/6739)
* Revert "fix" (#6646) ([902200e](https://github.com/99linesofcode/laravel-skeleton/commit/902200e7aac4af7efff60ed7ee958932b83ff2e4)), closes [#6646](https://github.com/99linesofcode/laravel-skeleton/issues/6646)
* Revert "Fixes tests failing due database not available (#6297)" (#6299) ([5d93ebd](https://github.com/99linesofcode/laravel-skeleton/commit/5d93ebdb76383c11525714aa1fb06ab234ea8811)), closes [#6297](https://github.com/99linesofcode/laravel-skeleton/issues/6297) [#6299](https://github.com/99linesofcode/laravel-skeleton/issues/6299)
* Revert "Rename migration tables (#6295)" (#6298) ([3f1426a](https://github.com/99linesofcode/laravel-skeleton/commit/3f1426a55a56cd7187e8b96b82ff6e97dc0a603f)), closes [#6295](https://github.com/99linesofcode/laravel-skeleton/issues/6295) [#6298](https://github.com/99linesofcode/laravel-skeleton/issues/6298)
* Revert "Let database handle default collation (#6241)" (#6266) ([024c86a](https://github.com/99linesofcode/laravel-skeleton/commit/024c86a24bdc8b02c38d41442f3908aae09f31a7)), closes [#6241](https://github.com/99linesofcode/laravel-skeleton/issues/6241) [#6266](https://github.com/99linesofcode/laravel-skeleton/issues/6266)
* Revert "Fix incorrect collation for MySQL 8 (#6239)" (#6240) ([96d3ecf](https://github.com/99linesofcode/laravel-skeleton/commit/96d3ecf5c26577530306374eb8e164fdc7425978)), closes [#6239](https://github.com/99linesofcode/laravel-skeleton/issues/6239) [#6240](https://github.com/99linesofcode/laravel-skeleton/issues/6240)
* Revert "add ses-v2 mailer in config (#6112)" (#6115) ([1bb530c](https://github.com/99linesofcode/laravel-skeleton/commit/1bb530c6090fdc58aace03cf8eb382574bec8b2f)), closes [#6112](https://github.com/99linesofcode/laravel-skeleton/issues/6112) [#6115](https://github.com/99linesofcode/laravel-skeleton/issues/6115)
* Revert "Add Redis facade as comment in app.config (#5813)" (#5814) ([f2b8023](https://github.com/99linesofcode/laravel-skeleton/commit/f2b8023df3725631db1af11480b7f0f0b2576c74)), closes [#5813](https://github.com/99linesofcode/laravel-skeleton/issues/5813) [#5814](https://github.com/99linesofcode/laravel-skeleton/issues/5814)
* Revert "Fix .gitattributes consistency with .editorconfig (#5802)" (#5809) ([6c1f430](https://github.com/99linesofcode/laravel-skeleton/commit/6c1f430aa76809084668f9a97121bd2ca8bafa10)), closes [#5802](https://github.com/99linesofcode/laravel-skeleton/issues/5802) [#5809](https://github.com/99linesofcode/laravel-skeleton/issues/5809)
* Revert "Uses `LazilyRefreshDatabase` by default (#5696)" (#5700) ([6a68092](https://github.com/99linesofcode/laravel-skeleton/commit/6a68092228844b1793bbcf4f0bf7c5ba2c9bd16c)), closes [#5696](https://github.com/99linesofcode/laravel-skeleton/issues/5696) [#5700](https://github.com/99linesofcode/laravel-skeleton/issues/5700)
* Revert "Change "Login" text to "Log in" (#5536)" (#5537) ([22626b5](https://github.com/99linesofcode/laravel-skeleton/commit/22626b5701cc7557d4bd45a6af5730027fc4a061)), closes [#5536](https://github.com/99linesofcode/laravel-skeleton/issues/5536) [#5537](https://github.com/99linesofcode/laravel-skeleton/issues/5537)
* Revert "Fix PHPUnit bool server consts result in null (#5409)" (#5411) ([c6c41f1](https://github.com/99linesofcode/laravel-skeleton/commit/c6c41f11b8ea3065f035fbb6a6f570b7bfba0037)), closes [#5409](https://github.com/99linesofcode/laravel-skeleton/issues/5409) [#5411](https://github.com/99linesofcode/laravel-skeleton/issues/5411)
* Revert "Apply fixes from StyleCI (#5356)" (#5357) ([407b6b8](https://github.com/99linesofcode/laravel-skeleton/commit/407b6b8b04820a7fc0eb3143a8255abbeabb3eb9)), closes [#5356](https://github.com/99linesofcode/laravel-skeleton/issues/5356) [#5357](https://github.com/99linesofcode/laravel-skeleton/issues/5357)
* Revert "Apply fixes from StyleCI (#5006)" ([5df3b7b](https://github.com/99linesofcode/laravel-skeleton/commit/5df3b7b1fe07a22d3275180ece0b31f45682f07e)), closes [#5006](https://github.com/99linesofcode/laravel-skeleton/issues/5006)
* Revert "According to PHP Bug 78516 Argon2 requires at least 8KB (#5097)" (#5102) ([56157b9](https://github.com/99linesofcode/laravel-skeleton/commit/56157b9cd201b5dc6fbe5f9f73014fa32e5a7838)), closes [#5097](https://github.com/99linesofcode/laravel-skeleton/issues/5097) [#5102](https://github.com/99linesofcode/laravel-skeleton/issues/5102)
* Revert "Set argon defaults to prevent password_hash(): Memory cost is outside of allowed memory range on PHP 7.4 (#5094)" (#5095) ([31394de](https://github.com/99linesofcode/laravel-skeleton/commit/31394de4d736c171d40bb03d50313c60b0e4af38)), closes [#5094](https://github.com/99linesofcode/laravel-skeleton/issues/5094) [#5095](https://github.com/99linesofcode/laravel-skeleton/issues/5095)
* Revert "Bump PHPUnit" ([af15fe5](https://github.com/99linesofcode/laravel-skeleton/commit/af15fe5ec688f59522e898dc74e0de54d84c3d96))
* Revert "Exclude StyleCI config from exported files (#5012)" ([ccea56b](https://github.com/99linesofcode/laravel-skeleton/commit/ccea56b6f910649d8a6ee25f61896d2b96e90496)), closes [#5012](https://github.com/99linesofcode/laravel-skeleton/issues/5012)
* Revert "Make view with response status and headers" ([70f2836](https://github.com/99linesofcode/laravel-skeleton/commit/70f283606068845710f62b24dee944ee82bdbf47))
* Revert "Docu on how to ensure foreign() works" ([546c962](https://github.com/99linesofcode/laravel-skeleton/commit/546c96261254373b7b366ce294aeba56636611c6))
* Revert "Added a function for handling HTML special characters" ([23a25b9](https://github.com/99linesofcode/laravel-skeleton/commit/23a25b9abb3442938595d1d3b249d73d039bf5bd))



## [0.3.1](https://github.com/99linesofcode/laravel-skeleton/compare/v0.3.0...v0.3.1) (2026-11-09)


### Bug Fixes

* **deps:** bump brace-expansion from 5.0.9 to 5.0.12 ([#229](https://github.com/99linesofcode/laravel-skeleton/issues/229)) ([6890c47](https://github.com/99linesofcode/laravel-skeleton/commit/6890c4756e3b679605d0e3ee8763dbb4771cb0f7))
* **deps:** bump devshell from `4075c8d` to `5278d4d` ([#226](https://github.com/99linesofcode/laravel-skeleton/issues/226)) ([93ad954](https://github.com/99linesofcode/laravel-skeleton/commit/93ad9545b188b59140346b6c5ec5a4ea3e2d42c7))
* **deps:** bump follow-redirects from 1.16.0 to 1.16.1 ([#234](https://github.com/99linesofcode/laravel-skeleton/issues/234)) ([66a313a](https://github.com/99linesofcode/laravel-skeleton/commit/66a313a7600182a678d32e2b8ec3805bd6507592))
* **deps:** bump follow-redirects from 1.16.1 to 1.16.2 ([#237](https://github.com/99linesofcode/laravel-skeleton/issues/237)) ([98be77c](https://github.com/99linesofcode/laravel-skeleton/commit/98be77c5063ccc78190fa1f4854e569a81cfb2f7))
* **deps:** bump ip-address from 10.2.0 to 10.7.4 ([#231](https://github.com/99linesofcode/laravel-skeleton/issues/231)) ([b5e8b7b](https://github.com/99linesofcode/laravel-skeleton/commit/b5e8b7b4a436f547363d854b2ea99e7533371a64))
* **deps:** bump source-map-js from 1.2.1 to 1.2.2 ([#230](https://github.com/99linesofcode/laravel-skeleton/issues/230)) ([baf7240](https://github.com/99linesofcode/laravel-skeleton/commit/baf7240144c368ca5a2f3a7a775a81fa2211303b))



# [0.3.0](https://github.com/99linesofcode/laravel-skeleton/compare/v0.2.3...v0.3.0) (2026-10-06)


### Features

* **lint:** enforce the layer contract with deptrac ([#224](https://github.com/99linesofcode/laravel-skeleton/issues/224)) ([df4d280](https://github.com/99linesofcode/laravel-skeleton/commit/df4d280f7bdd92a4b7fce7f73837767b7beda7d7))



