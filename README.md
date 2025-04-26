````markdown
# AccProBook

**AccProBook** is a robust web application designed to streamline financial operations and manage essential business records efficiently. With full CRUD operations, detailed entity management, and professional PDF reporting, it’s perfect for small to medium businesses.

---

## Branches

- **master**: Original codebase without Docker integration.
- **dockerise**: Docker-enabled branch containing:
  - Dockerfiles for MariaDB (`mariadb.Dockerfile`), PHP-FPM (`PHP.Dockerfile`), and Nginx (`nginx.Dockerfile`).
  - A Makefile to automate image builds and pushes.
  - `docker-compose.yml` for easy local deployment of the full stack.

---

## Features

- **CRUD Operations**: Manage Customers, Companies, Credits, Debits, and Invoices.
- **PDF Generation**: Create Balance Sheets and Invoices in PDF format.
- **Modular Design**: Separate services for web server, PHP-FPM, and database.
- **Docker-Ready**: Pre-built images on Docker Hub for zero-setup runs.

---

## Quick Local Run (No Git Clone Required)

1. **Save** the following as `docker-compose.yml` on your machine:

   ```yaml
   services:
     web:
       image: apilk/accprobook:nginx
       container_name: accprobook_web
       ports:
         - "80:80" # modify the left port , to change the hosting port
       depends_on:
         - php
       volumes:
         - app_data:/usr/share/nginx/html
       networks:
         - accProBook

     php:
       image: apilk/accprobook:php
       container_name: accprobook_php
       expose:
         - "9000"
       depends_on:
         - mysql
       volumes:
         - app_data:/usr/share/nginx/html
       networks:
         - accProBook

     mysql: # don't change this name i.e. mysql
       image: apilk/accprobook:db
       container_name: accprobook_db
       ports:
         - "3360:3306"
       volumes:
         - db_data:/var/lib/mysql
       environment:
         MYSQL_ROOT_PASSWORD: "secret"
       networks:
         - accProBook
       restart: unless-stopped

   volumes:
     db_data:
     app_data:

   networks:
     accProBook:
       driver: bridge
   ```
````

2. **Launch** all services with one command:

   ```bash
   docker compose up -d
   ```

3. **Access** the application at:

   - **Web UI:** [http://localhost](http://localhost)
   - **MariaDB:** Host `localhost`, Port `3360`, User `root`, Password `secret`, Database `ProBook`.

4. **Stop & Clean Up:**

   ```bash
   docker compose down
   ```

---

## Development Setup (With Git Clone)

For code changes, migrations, or branch work:

```bash
git clone https://github.com/Apil-Khadka/AccProBook.git
cd AccProBook
# Switch to Docker-enabled branch
git checkout dockerise
# Build & run the stack
docker compose up -d --build
```

- To work on the original (non-Docker) code, switch back:
  ```bash
  git checkout master
  ```

---

## Native PHP Setup (master branch)

If you prefer to run without Docker:

```bash
# 1. Clone master
git clone https://github.com/Apil-Khadka/AccProBook.git
cd AccProBook
git checkout master

# 2. Install dependencies
cd www && composer install && cd ..

# 3. Import the database
mysql -u root -p ProBook < database/AccProBook.sql

# 4. Start PHP server
cd www && php -S localhost:8000
```

Browse to [http://localhost:8000](http://localhost:8000).

---

## Contributing

Contributions are welcome!

1. Fork the repo, create a feature branch, commit changes, and open a PR.
2. For Docker-related changes, work in the `dockerise` branch.

---

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

---

## Author

Developed by [Apil Khadka](https://github.com/Apil-Khadka)

```

```
