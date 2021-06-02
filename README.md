# poc-common-and-shopkeepers

#### Running project!

```bash
git clone https://github.com/lucasdumer/poc-common-and-shopkeepers.git
cd poc-common-and-shopkeepers
docker build . 
# get successfully build hash from build end
docker run -it -w /var/www -v $(pwd):/var/www {successfully built hash} composer install
cp .env.example .env
#configure databases envs in .env
docker-compose up --build
docker run -it -w /var/www -v $(pwd):/var/www {successfully built hash} php artisan migrate:install
docker run -it -w /var/www -v $(pwd):/var/www {successfully built hash} php artisan migrate
```
