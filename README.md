2Gis BE mobile
=========
Back-end часть mobile проекта летней школы разработки 2Gis.

Базовая часть url api http://178.62.48.238/api

Запросы выглядят так: 

    http://178.62.48.238/api/search/companies/пиво/page/1/coords/12.345678/87.654321/radius/1000

Виды запросов
----
### Организации

    /minicompany/{{id}}

```javascript
БЛА БЛА БЛА
```

    /company/{{id}}

```javascript
{
  "result": {
    "additional_info": {
      "avg_price": 500
    },
    "id": "141266769532084",
    "name": "Фазенда, досугово-развлекательный центр",
    "firm_group": {
      "id": "141275459395820",
      "count": "1"
    },
    "address": "Советская, 14а",
    "contacts": [
      {
        "name": "",
        "contacts": [
          {
            "type": "phone",
            "value": "(383) 223-90-94",
            "register_bc_url": "http://stat.api.2gis.ru/?v=1.3&hash=1d39nw8987HIJHHJ142huvef6A6A17291A2B4428562347G42c2969G43J0I0931rv80"
          },
          {
            "type": "email",
            "value": "fazenda14a@ngs.ru",
            "register_bc_url": "http://stat.api.2gis.ru/?v=1.3&hash=183Cnw8987HIJHHJ1b2Buvef6A6A172919264428562347G4292c69G49J0I0931rv6c"
          }
        ]
      }
    ],
    "schedule": {
      "Mon": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Tue": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Wed": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Thu": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Fri": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Sat": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      },
      "Sun": {
        "working_hours-0": {
          "from": "12:00",
          "to": "00:00"
        }
      }
    },
    "payoptions": [
      "Cash",
      "Visa",
      "Mastercard"
    ],
    "rating": "3",
    "rubrics": [
      "Кафе",
      "Рестораны",
      "Банкетные залы",
      "Кейтеринг",
      "Кафе-кондитерские / Кофейни"
    ],
    "reviews_count": 25,
    "status": 60
  }
}
```

### Здания
    minihouse/{{lon}}/{{lat}}
    minihousecompany/{{id}}
    house/{{id}}
### Поиск по ключевому слову
    search/companies/{{query}}/page/{{page}}/coords/{{lon}}/{{lat}}/radius/{{rad}}
   
```javascript
{
    result: [
        {
            id: "141265769869669",
            name: "Море и Суши, магазин полезных продуктов",
            address: "Писарева, 53",
            rubrics: [
                "Ингредиенты / готовая продукция японской кухни",
                "Чай / Кофе",
                "Специи / Пряности"
            ],
            reviews_count: 37,
            additional_info: {
                currency: "RUB"
            },
            rating: "4.5",
            status: 60
        },
        ...
    ]
}
```
status - переменная, определяющая, закрыто предприятие или открыто. Принимает следующие значения:
    0, если организация сейчас закрыта 
    1-59, если до закрытия организации осталось столько минут
    60, если до закрытия осталось 60 и более минут

    search/markers/{{query}}/coords/{{lon}}/{{lat}}/radius/{{rad}}

```javascript
{
    result: [
        {
            id: "141265769869669",
            coord: "82.919950220543;55.049291323461"
        },
        ...
    ]
}
```
