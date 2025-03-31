
![Logo](https://ict-flex.nl/wp-content/uploads/2023/08/ICT-Flex-v2.png)


# Projectkaarten

Het project is ontworpen om een ​​online kaartenproject voor studenten te maken.


## Run Locally

### Clone the project

```bash
  git clone https://github.com/Lonja971/projectkaarten.git
```

### Go to the project directory

```bash
  cd projectkaarten
```

### Install Laravel dependencies

```bash
  php artisan install
```

### Maak de .env

Hernoem het .env-voorbeeld naar .env-bestand. Voeg daar uw database-informatie toe.

### Start the server

```bash
  php artisan serve
```



## API Reference

#### Get all users ( paginate - 10 )

```http
  GET | /api/users
```

#### Store new user

```http
  POST | /api/users/
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `full_name` | `string` | **Required**. Volledige gebruikersnaam |
| `identifier`    | `string` | **Required**. Gebruikers-ID (bijvoorbeeld leerling- of docentnummer) |
| `role_id`      | `integer` | **Required**. Gebruikersrol-ID |
| `email`      | `string` | **Required**. Email |
| `password`      | `string` | **Required**. Password |

#### Get user

```http
  GET | /api/users/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |
| `data`    | `string` | De naam van de parameter die u wilt ophalen |


#### Update user

```http
  PATCH/PUT | /api/users/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |
| `full_name` | `string` | Volledige gebruikersnaam |
| `identifier`    | `string` | Gebruikers-ID (bijvoorbeeld leerling- of docentnummer) |
| `role_id`      | `integer` | Gebruikersrol-ID |
| `email`      | `string` | Email |
| `password`      | `string` | Password |

#### Destroy user

```http
  DELETE | /api/users/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Search user (find user id)

```http
  GET | /api/users/search
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `data` | `string` | **Required**. Op welke parameter zoeken we (bijvoorbeeld `full_name`) |
| `input` | `string` | **Required**. Uw zoekinhoud|


## Authors

- [@Lonja971](https://github.com/Lonja971)
- [@KyanuDeltion](https://github.com/KyanuDeltion)

