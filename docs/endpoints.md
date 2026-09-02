## Endpoints

All endpoints live under `/api` and are protected by the `ApiToken` middleware, which
maps the `X-API-KEY` header to a permission (`key_1` … `key_5`). See [keys.md](keys.md)
for what each key is allowed to do. A key without permission for the endpoint gets
`{"code": 401, "message": "Unauthorized"}` (note: sent with HTTP status `200`).

Both `GET` endpoints only return records where `lan_id` is set — participants and
volunteers without a LAN ID are considered unassigned and are hidden from the API.

<details>
 <summary><code>GET</code> <code><b>/api/data</b></code></summary>

##### Headers

> | name        |  type      | data type      | description                                                  |
> |-------------|------------|----------------|--------------------------------------------------------------|
> | `x-api-key` |  required  | string         | Api key with permission                                      |


##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | json object                                                         |
> | `200`         | `application/json`                | {"code": 401,"message": "Unauthorized" } (key without permission)   |


##### Example response different keys


> KEY 5
```json
{
    "code": 200,
    "participants": [
        {
            "id": 1,
            "lan_id": 1,
            "ssn": "200901011234",
            "first_name": "John",
            "surname": "Doe",
            "grade": "8",
            "phone": null,
            "email": null,
            "guardian_name": "John Doe",
            "guardian_phone": "070123456",
            "guardian_email": "mail@mail.com",
            "is_visiting": 1,
            "friends": null,
            "special_diet": null,
            "status": "lan",
            "created_at": "2025-11-19T17:44:22.000000Z",
            "updated_at": "2025-11-19T17:47:17.000000Z"
        }
    ],
    "volunteers": [
        {
            "id": 1,
            "lan_id": 300,
            "first_name": "Jane",
            "surname": "Doe",
            "phone": "070123456",
            "email": "mail@mail.com",
            "areas": [
                "Städ",
                "Kiosk"
            ],
            "created_at": "2025-11-19T17:45:15.000000Z",
            "updated_at": "2025-11-19T17:48:05.000000Z"
        }
    ]
}
```

> KEY 2
```json
{
    "code": 200,
    "participants": [
        {
            "lan_id": 1,
            "first_name": "John",
            "surname": "Doe",
            "guardian_name": "John Doe"
        }
    ],
    "volunteers": [
        {
            "lan_id": 1,
            "first_name": "Jane",
            "surname": "Doe"
        }
    ]
}
```

> KEY 3
```json
{
    "code": 200,
    "participants": [
        {
            "id": 1,
            "lan_id": 1,
            "ssn": "200901011234",
            "first_name": "John",
            "surname": "Doe",
            "grade": "8",
            "phone": null,
            "email": null,
            "guardian_name": "John Doe",
            "guardian_phone": "070123456",
            "guardian_email": "mail@mail.com",
            "is_visiting": 1,
            "friends": null,
            "special_diet": null,
            "status": "lan",
            "created_at": "2025-11-19T17:44:22.000000Z",
            "updated_at": "2025-11-19T17:47:17.000000Z"
        }
    ]
}
```

> KEY 4
```json
{
    "code": 200,
    "participants": [
        {
            "lan_id": 1,
            "first_name": "John",
            "surname": "Doe",
            "guardian_name": "John Doe"
        }
    ]
}
```

> KEY 1
```json
{
    "code": 401,
    "message": "Unauthorized"
}
```

</details>

<details>
 <summary><code>GET</code> <code><b>/api/version</b></code></summary>

Returns the latest version number per table. The counter is bumped every time a
participant or volunteer is created, updated or deleted, so a client can poll this
endpoint and only re-fetch `/api/data` when the number changed. The value is `null`
if the table has no version rows yet.

##### Headers

> | name        |  type      | data type      | description                                                  |
> |-------------|------------|----------------|--------------------------------------------------------------|
> | `x-api-key` |  required  | string         | Api key with permission                                      |

##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | json object                                                         |
> | `200`         | `application/json`                | {"code": 401,"message": "Unauthorized" } (key without permission)   |



##### Example response different keys


> KEY 5
```json
{
    "code": 200,
    "participants": 3,
    "volunteers": 2
}
```

> KEY 2
```json
{
    "code": 200,
    "participants": 3,
    "volunteers": 2
}
```

> KEY 3
```json
{
    "code": 200,
    "participants": 3
}
```

> KEY 4
```json
{
    "code": 200,
    "participants": 3
}
```

> KEY 1
```json
{
    "code": 401,
    "message": "Unauthorized"
}
```

</details>

<details>
 <summary><code>POST</code> <code><b>/api/participant</b></code></summary>

##### Headers

> | name        |  type     | data type               | description                                                           |
> |-------------|-----------|-------------------------|-----------------------------------------------------------------------|
> | `x-api-key` |  required | string                  | Api key with permission                                               |

##### Body data 

> | name             |  type     | data type                | description                                                           |
> |------------------|-----------|--------------------------|-----------------------------------------------------------------------|
> | `member`         |  required | boolean                  | Participant membership                                                |
> | `first_name`     |  required | string                   | Participant first name                                                |
> | `surname`        |  required | string                   | Participant surname                                                   |
> | `ssn`            |  nullable | string                   | Participant social security number (12 digits, `YYYYMMDDXXXX`)        |
> | `grade`          |  required | string                   | Participant grade                                                     |
> | `phone`          |  nullable | string                   | Participant phone number                                              |
> | `email`          |  nullable | string                   | Participant email                                                     |
> | `guardian_name`  |  required | string                   | Participant guardian name                                             |
> | `guardian_phone` |  required | string                   | Participant guardian phone                                            |
> | `guardian_email` |  required | string                   | Participant guardian email                                            |
> | `is_visiting`    |  required | boolean                  | 1 = Visiting , 0 = LAN                                                |
> | `gdpr`           |  required | boolean                  | Participant accepts gdpr                                              |
> | `friends`        |  nullable | string                   | Participant want to sit with                                          |
> | `special_diet`   |  nullable | string                   | Participant special diet                                              |


```json
{
    "member": 1,
    "first_name": "Joe",
    "surname": "Doe",
    "ssn": "200901011234",
    "grade": "8",
    "phone": null,
    "email": null,
    "guardian_name": "Jane Doe",
    "guardian_phone": "070123456",
    "guardian_email": "email@email.com",
    "is_visiting": 1,
    "gdpr": 1,
    "friends": "Jake, James",
    "special_diet": "Laktos"
}
```
>


##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | {"code": 200, "message": "Participant was created successfully" }   |
> | `200`         | `application/json`                | {"code": 401,"message": "Unauthorized" } (key without permission)   |
> | `422`         | `application/json`                | Validation errors                                                   |


</details>

<details>
 <summary><code>POST</code> <code><b>/api/volunteer</b></code></summary>

##### Headers

> | name        |  type     | data type               | description                                                           |
> |-------------|-----------|-------------------------|-----------------------------------------------------------------------|
> | `x-api-key` |  required | string                  | Api key with permission                                               |


##### Body data 

> | name             |  type     | data type                | description                                                           |
> |------------------|-----------|--------------------------|-----------------------------------------------------------------------|
> | `first_name`     |  required | string                   | Volunteer first name                                                  |
> | `surname`        |  required | string                   | Volunteer surname                                                     |
> | `phone`          |  required | string                   | Volunteer phone number                                                |
> | `email`          |  required | string                   | Volunteer email                                                       |
> | `gdpr`           |  required | boolean                  | Volunteer accepts gdpr                                                |
> | `areas`          |  required | json                     | Volunteer want to help put in this areas                              |

> 
```json
{
    "first_name": "Jane",
    "surname": "Doe",
    "phone": "0700123456",
    "email": "email@email.com",
    "gdpr": 1,
    "areas": [
        "Städ", "Kiosk"
    ]
}
```
>


##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | {"code": 200, "message": "Volunteer was created successfully" }     |
> | `200`         | `application/json`                | {"code": 401,"message": "Unauthorized" } (key without permission)   |
> | `422`         | `application/json`                | Validation errors                                                   |


</details>
