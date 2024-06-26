# JRT Parcel - Courier Management System

A functional website built with Laravel and integrated with PostgreSQL to deliver a dynamic and scalable database.

## Description

JRT Parcel is a Courier Management System application designed to help delivery companies manage their operational aspects. This application includes order management, delivery, reports, as well as employee management. By using JRT Parcel, companies can increase their efficiency, productivity and service quality.

## Getting Started

### Installing

* <a href="https://www.php.net/downloads.php" target="_blank">PHP</a>
* <a href="https://www.postgresql.org/" target="_blank">PostgreSQL</a>
* <a href="https://www.apachefriends.org/download.html" target="_blank">XAMPP</a>
* <a href="https://getcomposer.org/" target="_blank">Composer</a>
* <a href="https://code.visualstudio.com/download" target="_blank">Visual studio code </a> or any other IDE

### Executing program

1.  **Clone this repository** :
    ``` 
    git clone https://github.com/JasonFTI45/JRT_Parcel.git
    ```

2. **Navigate to the project directory** :
    ``` 
    cd JRTParcel
    ```

3. **Install dependency composer** : 
    ``` 
    composer install 
    ``` 
    or (In short)
    ``` 
    composer i 
    ``` 

4. **Install Front End Assets** : 
    ``` 
    npm install 
    ```
    or (In short)
    ```
    npm i
    ```

5. **Setup ```.env ``` file**

6. **Generate APP_KEY in ```.env```** :
    ``` 
    php artisan key:generate
    ``` 
    or (In short) 
    ``` 
    php artisan key:gen 
    ``` 

7.  **Migrate database** : 
    ``` 
    php artisan migrate:fresh
    ```

8. **Seed data** : The Seeder contains dummy accounts
    ``` 
    php artisan db:seed 
    ```

9. **Start the server** : 
    ``` 
    php artisan serve 
    npm run dev 
    ``` 

10. **Open your web browser and navigate to default web http://127.0.0.1:8000/ to access JRT Parcel.**


## Watch
* Watch our <a href="https://youtu.be/2OKeQx1KL9A" target="_blank">Presentation</a> video, <a href="https://youtu.be/UUVgo0KStuQ" target="_blank">Demonstration</a> video, <a href="https://untarid-my.sharepoint.com/:p:/g/personal/tigo_535220235_stu_untar_ac_id/EaOM-AV6zFpJnRUz2HCYAD8BmjtsNF22ggvkGKdEWrhJIQ?e=ElOsMf" target="_blank">Power Point</a> and our <a href="https://drive.google.com/file/d/1qth37taLIYBgzJamLemGkcg4ux7uVExb/view?usp=sharing" target="_blank">Report</a>

# Repobeats

![Alt](https://repobeats.axiom.co/api/embed/4e250261eecbc5d0eae659b1e71959803051b9be.svg "Repobeats analytics image")
