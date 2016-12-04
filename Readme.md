# Запуск и тестирование

Запуск билда
```
docker network create apigateway_default
docker-compose create
```

Запуск сервиса
```
docker run --rm -p 8030:80 -p 2230:22 --sysctl=net.core.somaxconn=4096 --network=apigateway_default --name=test_app -v ${pwd}:/root/.ssh apigateway_openrest
```

Тестирование
```
docker start -i apigateway_ya-tank_1
docker run --rm -v ${pwd}:/var/loadtest -v ${pwd}:/root/.ssh  -it direvius/yandex-tank
```