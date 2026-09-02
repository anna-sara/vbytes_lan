## vBytes LAN

Registration and administration for the vBytes LAN: participants and volunteers sign up
through the API, and everything is administered in a Filament admin panel at `/logga_in`.

Built with Laravel 12, Filament 5 and Tailwind 4.

## Documentation

- [docs/endpoints.md](docs/endpoints.md) — the API endpoints, request bodies and example responses
- [docs/keys.md](docs/keys.md) — the API keys and what each one is allowed to read/write

## Admin panel

### Participants

- `lan_id` ("ID") is assigned manually and must be **unique** — it is edited inline in the
  table, and a participant without a LAN ID is hidden from the API.
- `ssn` (Swedish personnummer, 12 digits) can be stored per participant. It is shown as
  a hidden-by-default column in the table and is only exposed through `KEY 3` and `KEY 5`.
- `paid` and `member` are toggled directly in the table, `status` (`lan` / `reserv` /
  `besök`) is set by the API on signup and can be changed in the form.
- The table is grouped by status by default and can be filtered on status.
- CSV import (up to 100 000 rows) and CSV export from the table header.
  Note: the importer and exporter do **not** include `ssn`.
- `emailed` shows whether a mail has been sent; hovering it lists the mail templates used.
  The edit form has an "Emails sent" list with timestamps, template names and any errors.

### Volunteers

Same inline `lan_id` handling and CSV export. Volunteers have no `ssn` and no mail sending.

### Templates

- **Mail templates** (`Templates` → `Mailtemplates`): title is used as the email subject and
  the content is Markdown. `[NAME]` in the content is replaced with the participant's first
  name. A template can be marked as **draft**, which hides it from the send dialogs.
  A mail template can optionally be linked to an **SMS template**.
- **SMS templates** (`Templates` → `Smstemplates`): plain-text content, also with a draft
  toggle. An SMS is only sent as part of a mail template that links to it, never on its own,
  and the text is sent as-is (no `[NAME]` replacement).

### Sending mail and SMS

Mail is sent to `guardian_email`, either per participant ("Send email" row action, sent
immediately) or for a selection ("Send email" bulk action, queued). If the chosen mail
template has an SMS template linked, an SMS is also sent to `guardian_phone` — via an
email-to-SMS gateway: the message is mailed to `SMS_URL` with the phone number
(normalised to `0046…`) as the subject and the SMS text as the body. If `SMS_URL` is not
configured, no SMS is sent.

Every attempt is written to the email log — including failures, with the error message.
`emailed` is only set for participants whose sends had no errors.

### Email log

`Logs` → `Email log` is a read-only list of every send: time, LAN ID, address, mail and SMS
template, participant name and the error column (hidden by default).

### Users and login

Login is at `/logga_in` with password reset, email verification, email change verification
and optional email based multi-factor authentication (`users.has_email_authentication`).
The [Filament Gaze](https://github.com/DiscoveryDesign/filament-gaze) plugin shows a banner
when someone else has the same record open.

## Configuration

Beyond the standard Laravel variables:

> | variable            | description                                                                 |
> |---------------------|-----------------------------------------------------------------------------|
> | `API_KEY_1` … `API_KEY_5` | The API keys, see [docs/keys.md](docs/keys.md)                         |
> | `LAN_PLACE_AMOUNT`  | Number of LAN seats — signups beyond this get status `reserv`                |
> | `SMS_URL`           | Address of the email-to-SMS gateway. Leave empty to disable SMS              |

Mail must be configured (`MAIL_*`) and a queue worker (`php artisan queue:work`) has to run
for bulk sending, imports and exports — `QUEUE_CONNECTION=database` by default.

## Local development

```bash
docker compose up -d          # php/apache on :8080 and mariadb on :3306
composer install
npm install && npm run dev
php artisan migrate
php artisan queue:work
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
