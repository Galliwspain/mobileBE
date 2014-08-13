2Gis BE mobile
=========
Back-end часть mobile проекта летней школы разработки 2Gis.

Виды запросов 
----
### Организации

    /api/minicompany/{{id}}
    /api/company/{{id}}
### Здания
    /api/minihouse/{{lon}}/{{lat}}
    /api/minihousecompany/{{id}}
    /api/house/{{id}}
### Поиск по ключевому слову
    /api/search/companies/{{query}}/page/{{page}}/coords/{{lon}}/{{lat}}/radius/{{rad}}
   
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


    /api/search/markers/{{query}}/coords/{{lon}}/{{lat}}/radius/{{rad}}

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



