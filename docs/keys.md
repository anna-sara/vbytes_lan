## API Keys

The key is sent in the `X-API-KEY` header and is matched against
`config/apikeys.php`, i.e. the env variables `API_KEY_1` … `API_KEY_5`.
An unknown key — or a valid key without permission for the endpoint — gives
`{"code": 401, "message": "Unauthorized"}`.

> | key          | permissions                                                                          |
> |--------------|--------------------------------------------------------------------------------------|
> | `KEY 1`      | Can post Participants and Volunteers.                                                |
> | `KEY 2`      | {lan_id, first_name, surname, guardian_name} from table Participants and Volunteers  |
> | `KEY 3`      | All data from table Participants (including `ssn`)                                   |
> | `KEY 4`      | {lan_id, first_name, surname, guardian_name} from table Participants                 |
> | `KEY 5`      | Can get all Participants and Volunteers (including `ssn`).                           |

### Per endpoint

> | key          | `GET /api/data`                          | `GET /api/version`         | `POST /api/participant` | `POST /api/volunteer` |
> |--------------|------------------------------------------|----------------------------|-------------------------|-----------------------|
> | `KEY 1`      | –                                        | –                          | Yes                     | Yes                   |
> | `KEY 2`      | Participants + volunteers, limited fields| Participants + volunteers  | –                       | –                     |
> | `KEY 3`      | Participants, all fields                 | Participants               | –                       | –                     |
> | `KEY 4`      | Participants, limited fields             | Participants               | –                       | –                     |
> | `KEY 5`      | Participants + volunteers, all fields    | Participants + volunteers  | –                       | –                     |

### Fields returned by `GET /api/data`

> | scope                | fields                                                                                                                                                                     |
> |----------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
> | Participants, all    | id, lan_id, **ssn**, first_name, surname, grade, phone, email, guardian_name, guardian_phone, guardian_email, is_visiting, friends, special_diet, status, created_at, updated_at |
> | Participants, limited| lan_id, first_name, surname, guardian_name                                                                                                                                 |
> | Volunteers, all      | id, lan_id, first_name, surname, phone, email, areas, created_at, updated_at                                                                                               |
> | Volunteers, limited  | lan_id, first_name, surname                                                                                                                                                |

`ssn` is personal data (Swedish personnummer) — only hand out `KEY 3` and `KEY 5`
to clients that actually need it.
