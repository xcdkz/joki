# General
Build system requires docker, docker-compose, composer, php and [scss_mass_compiler](https://github.com/two-six/scss_mass_compiler) to build
# Instructions
**server run command(while in the project folder):**
```bash
composer run-script full-build --timeout 0
```

# TODO
- [X] Write notes using html
- [X] Render notes server-side
- [X] Two boxes in preview mode
- [X] Slight documentation for database
- [X] Fuzzy finder for notes(by users and/or title)
- [X] Second window to show text in markdown/html
- [X] Dashboard with notes
- [X] Ability to remove notes
- [X] Work on issue with overlapping note's links
- [X] Ability to edit notes
- [X] Ability to have multiple owners of the note
- [X] Owner account
- [X] Ability to search users if being an administrator
- [X] Administrator account
- [X] Ability to make administrators out of users as owner
- [X] Ability to remove users as administrator
- [X] Ability to search and remove administrators as owner
- [X] Ability to degrade administrators as owner
- [ ] Ability to change password and email address
- [ ] Write tests in PHPUnit
- [ ] Add captcha for register
- [ ] Work on frontend
- [ ] Host it on VPS
