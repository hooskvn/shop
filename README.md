## mettre en place API Platform
## https://symfony.com/doc/current/the-fast-track/fr/26-api.html

## Utiliser un Swagger (Swagger UI)

API :

http://127.0.0.1:8000/product/add
POST
{
	"title": "screen",
	"price": 700,
	"description": "bon produit",
	"isActive": false
}

http://127.0.0.1:8000/product/{id}
GET

http://127.0.0.1:8000/products/edit/{id}
PUT
{
	"title": "chair",
	"price": 650,
	"description": "très bon produit",
	"isActive": "avaible",
    "stock": 50
}

http://127.0.0.1:8000/products
GET

http://127.0.0.1:8000/products/available
GET

http://127.0.0.1:8000/user/add
POST
{
	"email": "emailtest3@gmail.com",
	"password": "123456",
	"role": ["ROLE_USER"]
}
Error : first arg must be of type "PasswordAuthenticatedUserInterface"

http://127.0.0.1:8000/products/{id}/edit/stock
PUT
{
    "stock": 30
}

http://127.0.0.1:8000/voucher/add
POST
{
	"title": "Promotion 50 euros",
	"code": "PROMO50",
	"type": "ECRAN",
	"amount": 50
}

http://127.0.0.1:8000/vouchers
GET


#####
#####


Proposition d'architecture :

Utiliser une architecture de style REST/RESTful.
Ces solutions communiquent entre elles par le protocole HTTP (requête/réponse).

Intérêt de la solution :
La communication peut être pilotée par des events (intérêt si on veut synchroniser l'ensemble).
Les solutions (ERP,CRM,...) peuvent être différentes les unes des autres elles communiquent de la même manière entre elles : langage agnostique.
Facilité d'implémentation et d'utilisation.
Sécurisation du transite des données (SSL).
Opérations CRUD possibles.

