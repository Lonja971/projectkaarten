
![Logo](https://ict-flex.nl/wp-content/uploads/2023/08/ICT-Flex-v2.png)


# Projectkaarten

Het project is ontworpen om een ​​online kaartenproject voor studenten te maken.


## Lokaal uitvoeren

### Kloon het project

```bash
  git clone https://github.com/Lonja971/projectkaarten.git
```

### Ga naar de projectdirectory

```bash
  cd projectkaarten
```

### Laravel-afhankelijkheden installeren

```bash
  php artisan install
```

### Maak de .env

Hernoem het .env-voorbeeld naar .env-bestand. Voeg daar uw database-informatie toe.

### Migreer de database

```bash
  php artisan migrate
```

### Start de server

```bash
  php artisan serve
```



## API-referentie

#### Alle gebruikers ophalen ( paginate - 10 )

```http
  ${domain}/api/users?api_key=${api_key}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `GET` |  |
| `api_key` | `string` | **Required**. Api key |

#### Nieuwe gebruiker opslaan

```http
  ${domain}/api/users?api_key=${api_key}&full_name=${full_name}&identifier=${identifier}&role_id=${role_id}&email=${email}&password=${password}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `POST` |  |
| `api_key` | `string` | **Required**. Api key |
| `full_name` | `string` | **Required**. Volledige gebruikersnaam |
| `identifier`    | `string` | **Required**. Gebruikers-ID (bijvoorbeeld leerling- of docentnummer) |
| `role_id`      | `integer` | **Required**. Gebruikersrol-ID |
| `email`      | `string` | **Required**. Email |
| `password`      | `string` | **Required**. Password |

#### Gebruiker ophalen by id

```http
  ${domain}/api/users/${id}?api_key=${api_key}&column=${column}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `GET` |  |
| `api_key` | `string` | **Required**. Api key |
| `id`      | `string` | **Required**. Id of item to fetch |
| `column`    | `string` | De naam van de parameter die u wilt ophalen |


#### Gebruiker bijwerken

```http
  ${domain}/api/users/${id}?api_key=${api_key}&full_name=${full_name}&identifier=${identifier}&role_id=${role_id}&email=${email}&password=${password}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `PATCH/PUT` |  |
| `api_key` | `string` | **Required**. Api key |
| `id`      | `string` | **Required**. Id of item to fetch |
| `full_name` | `string` | Volledige gebruikersnaam |
| `identifier`    | `string` | Gebruikers-ID (bijvoorbeeld leerling- of docentnummer) |
| `role_id`      | `integer` | Gebruikersrol-ID |
| `email`      | `string` | Email |
| `password`      | `string` | Password |

#### Gebruiker vernietigen

```http
  ${domain}/api/users/${id}?api_key=${api_key}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `DELETE` |  |
| `api_key` | `string` | **Required**. Api key |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Zoek gebruiker (vind gebruikers-id)

```http
  ${domain}/api/users/search?api_key=${api_key}&column=${column}&value=${value}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Method` | `GET` |  |
| `api_key` | `string` | **Required**. Api key |
| `column` | `string` | **Required**. Op welke parameter zoeken we (bijvoorbeeld `full_name`) |
| `value` | `string` | **Required**. Uw zoekinhoud|


## Auteurs

- [@Lonja971](https://github.com/Lonja971)
- [@KyanuDeltion](https://github.com/KyanuDeltion)

