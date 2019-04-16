# CCID-MediaWiki

Script to add CCID users to MediaWiki


## Deploy Changes

To deploy changes:
1. Log into server
2. `cd /srv/CCID-MediaWiki`
3. `sudo git pull`


## Field Mappings

Assuming the following data from [creativecommons/CCID-cas][ccid-cas]:

CCID Field      | Example Data
--------------- | ------------
email           | `arthur@creativecommons.org`
nickname        | `Arthur Philip Dent`
global          | `arthurdent`

[ccid-cas]: https://github.com/creativecommons/CCID-cas/


### Wiki

[`addCCIDUser.php`](addCCIDUser.php):

WikiMedia | CCID   | Example                      | Notes
----------| ------ | ---------------------------- | -----
Username  | global | `CCID-arthurdent`            | `'CCID-' . $global`
Email     | email  | `arthur@creativecommons.org` |
Real Name | global | `arthurdent` |


### Teamspace

[`addTeamspaceCCIDUser.php`](addTeamspaceCCIDUser.php):

WikiMedia | CCID   | Example                      | Notes
----------| ------ | ---------------------------- | -----
Username  | email  | `Arthur@creativecommons.org` | `ucfirst($email)`
Email     | email  | `arthur@creativecommons.org` |
Real Name | global | `arthurdent` |
