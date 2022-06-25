# Users
- _id: integer
- username: string
- email: string
- password: string
- xid_id: string
- pastes: array(integer (`_id`))
- role: string(`user`, `administrator`, `owner`)

# Pastes
- _id: integer
- title: string
- content: string
- xid_id: string
- creator: integer(`_id`)
- creator_username: string
- owners: array(integer (`_id`))
- visibility: string(`pub`, `unl` or `pri`)
- date: string