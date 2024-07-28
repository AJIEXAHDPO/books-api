# Publications API 
Simple Api for book shop. 
Powered by Symfony 7 framework.
## Endpoints 
- `GET: /book` - creating couriers. Returns created couriers info with Id.
- `POST: /book` - creating orders. Return an array of created orders with Id.
- `POST: /author` - completes an order by Id and courier Id. Returns completed order Id.
- `PATCH|PUT: /publisher/{id}` - change selected courier info. Returns updated courier data.
- `DELETE: /author/{id}` - returns selected courier info.
- `DELETE: /publisher/{id}` - returns selected courier info.
- `DELETE: /api/book/{id}` - returns selected courier info.
## Install
Clone repository on your device.
into the project folder `cd publications-api`
Run docker container
```sh
docker-compose up --build -d
```
Get into php container bash
```
docker exec -it book_api_php bash
```
Execute the comands below under the php container:<br/>
Get into the app folder `cd /var/www/http`
Install all dependencies `composer install`<br/>
Create database migrate it and add fixtures<br/>
`php bin/console doctrine:database:create`<br/>
`php bin/console doctrine:migrations:migrate`<br/>
`php bin/console doctrine:fixtures:load`<br/>

You also can delete authors with no books via command
`php bin/console authors:delete-extra`

Go to the `localhost:8080` to start the app
