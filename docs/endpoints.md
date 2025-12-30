## Endpoints

<details>
 <summary><code>GET</code> <code><b>/data</b></code></summary>

##### Headers

> | name        |  type      | data type      | description                                                  |
> |-------------|------------|----------------|--------------------------------------------------------------|
> | `x-api-key` |  required  | string         | Api key with permission                                      |


##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | json object                                                         |
> | `401`         | `application/json`                | {"code": 401,"message": "Unauthorized" }                            |



##### Example response different keys


> KEY 1
```json
{
    "participants": [
        {
            "id": 1,
            "lan_id": 1,
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
            "comment": null,
            "created_at": "2025-11-19T17:45:15.000000Z",
            "updated_at": "2025-11-19T17:48:05.000000Z"
        }
    ]
}
```

> KEY 2
```json
{
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
    "participants": [
        {
            "id": 1,
            "lan_id": 1,
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

</details>

<details>
 <summary><code>GET</code> <code><b>/version</b></code></summary>

##### Headers

> | name        |  type      | data type      | description                                                  |
> |-------------|------------|----------------|--------------------------------------------------------------|
> | `x-api-key` |  required  | string         | Api key with permission                                      |

##### Responses

> | http code     | content-type                      | response                                                            |
> |---------------|-----------------------------------|---------------------------------------------------------------------|
> | `200`         | `application/json`                | json object                                                         |
> | `401`         | `application/json`                | {"code": 401,"message": "Unauthorized" }                            |



##### Example response different keys


> KEY 1
```json
{
    "success": true,
    "participants": 3,
    "volunteers": 2
}
```

> KEY 2
```json
{
    "success": true,
    "participants": 3,
    "volunteers": 2
}
```

> KEY 3
```json
{
    "success": true,
    "participants": 3
}
```

> KEY 4
```json
{
    "success": true,
    "participants": 3
}
```

</details>

<details>
 <summary><code>POST</code> <code><b>/participant</b></code></summary>

##### Headers

> | name        |  type     | data type               | description                                                           |
> |-------------|-----------|-------------------------|-----------------------------------------------------------------------|
> | `x-api-key` |  required | string                  | Api key with permission                                               |

##### Body data 

> | name             |  type     | data type                | description                                                           |
> |------------------|-----------|--------------------------|-----------------------------------------------------------------------|
> | `first_name`     |  required | string                   | Participant first name                                                |
> | `surame`         |  required | string                   | Participant surname                                                   |
> | `grade`          |  required | string                   | Participant grade                                                     |
> | `phone`          |  nullable | string                   | Participant phone number                                              |
> | `email`          |  nullable | string                   | Participant email                                                     |
> | `guardian_name`  |  required | string                   | Participant guardian name                                             |
> | `guardian_phone` |  required | string                   | Participant guardian phone                                            |
> | `guardian_email` |  required | string                   | Participant guardian email                                            |
> | `is_visiting`    |  required | boolean                  | 1 = Visiting , 0 = LAN                                                |
> | `gdpr`           |  required | booelan                  | Participant accepts gdpr                                              |
> | `friends`        |  nullable | string                   | Participant want to sit with                                          |
> | `special_diet`   |  nullable | string                   | Participant special diet                                              |


```json
{
    "first_name": "Joe",
    "surname": "Doe",
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
> | `401`         | `application/json`                | {"code": 401,"message": "Unauthorized" }                            |


</details>

<details>
 <summary><code>POST</code> <code><b>/volunteer</b></code></summary>

##### Headers

> | name        |  type     | data type               | description                                                           |
> |-------------|-----------|-------------------------|-----------------------------------------------------------------------|
> | `x-api-key` |  required | string                  | Api key with permission                                               |


##### Body data 

> | name             |  type     | data type                | description                                                           |
> |------------------|-----------|--------------------------|-----------------------------------------------------------------------|
> | `first_name`     |  required | string                   | Volunteer first name                                                  |
> | `surame`         |  required | string                   | Volunteer surname                                                     |
> | `phone`          |  required | string                   | Volunteer phone number                                                |
> | `email`          |  required | string                   | Volunteer email                                                       |
> | `gdpr`           |  required | booelan                  | Volunteer accepts gdpr                                                |
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
> | `401`         | `application/json`                | {"code": 401,"message": "Unauthorized" }                            |


</details>



