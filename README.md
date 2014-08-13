2Gis BE mobile
=========
Back-end часть mobile проекта летней школы разработки 2Gis.



Виды запросов 
----
### Организации

    /api/minicompany/{{id}}
    /api/company/{{id}}
### Здания
    /api/minihouse/{{lat}}/{{lng}}
    /api/minihousecompany/{{id}}
    /api/house/{{id}}
### Поиск по ключевому слову
    /api/search/companies/{{query}}
    /api/search/markers/{{query}}
