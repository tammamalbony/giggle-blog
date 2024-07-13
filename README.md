![image](https://github.com/user-attachments/assets/76036c21-1253-4583-9876-4befa843733b)

## Giggle Blog Web Application ![apple-touch-icon](https://github.com/user-attachments/assets/7bd5322d-6849-4e2e-89f6-7b967216d01a)


### Overview
Giggle is a simple CRUD Blog web application built using Yii v1.1 and MySQL for the backend. The frontend is developed with native HTML, CSS, JavaScript, and Bootstrap. The application supports user authentication, including sign-in, sign-up, and email verification. Verified users can perform CRUD operations on blog posts, mark posts as public or private, like posts, and search and filter posts by title, description, date, and author.
![4a2b7cd8-5bfe-480c-b4b7-37f0cde45199](https://github.com/user-attachments/assets/abdda14a-c9f3-4f05-826c-a35b75fefbd1)

### Features
- **User Authentication**: Sign-in, Sign-up, Email verification.
- **CRUD Operations**: Create, Read, Update, Delete blog posts.
- **Real-time Search**: Search and filter posts in real-time.
- **Post Interactions**: Users can like posts.
- **Responsive Design**: Mobile-friendly layout.
- **Email Notifications**: Email verification and other notifications.
- **Post Filtering**: Filter posts by title, description, date, and author.
- **Real-time Updates**: See new posts and updates in real-time.
![image](https://github.com/user-attachments/assets/b398d708-a9f6-4a90-a3e8-f08c9b94f58b)


### Technologies Used
- **Backend**: Yii v1.1, MySQL
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Authentication**: Yii’s built-in user authentication mechanism.
- **AJAX**: Used for real-time search and updates.

### Project Structure
Refer to the `files and directories structure.txt` for a detailed structure. Here is a brief overview:

- `protected/`
  - `controllers/` - Contains the application controllers.
  - `models/` - Contains the application models.
  - `views/` - Contains the application views.
  - `config/` - Configuration files.
  - `components/` - Custom components.
  - `runtime/` - Runtime files.
  - `uploads/` - uploads files.
  - `custom/` - custom front-end files.
    
![download](https://github.com/user-attachments/assets/2d562fa7-0fa2-465a-a44f-d603e1b87f65)

### Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/tammamalbony/giggle-blog.git
    cd giggle-blog
    ```

2. **Install dependencies**:
    Ensure you have Composer installed, then run:
    ```bash
    composer install
    composer update
    ```

3. **Configure the application**:
    Configurations are managed through environment variables.

4. **Run the migrations**:
    Ensure your database is created and run:
    ```bash
    php create_database.php
    ./protected/yiic migrate
    ```
    The Demo data is included : (users)
       ```bash
   
    ```
    > [!NOTE]
> Useful information that users should know, .

> [!TIP]
> verified user with private post
> email : Wafaabufaour1@gmail.com
> password : Wafaabufaour1@gmail.com

> [!IMPORTANT]
> verified user
> email : Wafaabufaour2@gmail.com
> password : Wafaabufaour2@gmail.com

> [!WARNING]
> not verified user with private post
> email : Wafaabufaour1@gmail.com
> password : Wafaabufaour1@gmail.com

> [!CAUTION]
> each user has an access to specific features based on his account status
![image](https://github.com/user-attachments/assets/a1c57602-14c7-48fb-bf68-1da75707e0e4)


6. **Set up your app to run **:
    ```bash
    cd protected
    composer install
    composer update
    cd..
    ```
![image](https://github.com/user-attachments/assets/ec633153-5a20-4722-af6f-dfdacbb87d29)

### Configuration
Configurations are managed through environment variables and configuration files located in `protected/config/`.


## Progressive Web App (PWA)![image](https://github.com/user-attachments/assets/633f27e8-f90a-4399-a4d7-2aef57388b7d)

![image](https://github.com/user-attachments/assets/d96e4250-9c2b-42d0-96b5-0fd980c15b74)

This application is also a Progressive Web App (PWA), that may will provide the following benefits:

- **Offline Capabilities:** Users can access the blog and read posts even when they are offline.
- **Add to Home Screen:** Users can add the app to their home screen on mobile devices for a native app-like experience.
- **Fast Loading Times:** The app is optimized to load quickly and perform efficiently, even on slow networks.

**Environment Variables**:
```
APP_NAME=Giggle
APP_ENV=local
APP_KEY=base64:IXb/yRofWVihT4nKyqg9iB95MDRoJ1rhS27EatlOWts=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

GII_PASSWORD=u.DHHZjtRdh*bdNY1
ADMIN_MAIL=webmaster@example.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

ITEMS_PER_PAGE=3
EDITOR_ENABLE=false

UPLOAD_DIR=uploads

MAX_IMAGE_SIZE=1024
MAX_IMAGE_WIDTH=2000
MAX_IMAGE_HIGHT=2000

MAX_COMMENT_WORDS=100
MIN_COMMENT_WORDS=5

ANIMATION_ENABLE=false

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_HOST=localhost
DB_NAME=u893299518_blog
DB_USERNAME=u893299518_blogdbuser
DB_PASSWORD=u.DHHZjtRdh*bdNY1
DB_CHARSET=utf8

IS_EMAIL_ENABEL=false

MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_USERNAME=63a033df3bbc17
MAIL_PASSWORD=a15253a8787703
MAIL_PORT=2525
MAIL_SMTP_SECURE=tls
MAIL_SMTP_AUTH=true
MAIL_FROM=test@task.com

REAL_TIME_SEARCH=true
REAL_TIME_UPDATE=true
REAL_TIME_SOCKET=false
INTERVAL_TIME=5000

REALTIME_WEBSOCKET=false
CSRF_ENABLE=false
```



### License
This project is licensed under the MIT License - see the LICENSE.md file for details.

---

This README provides an overview of the Giggle Blog Web Application, how to install and configure it, and how to contribute to the project. If you need more specific instructions or run into any issues, feel free to ask!
![image](https://github.com/user-attachments/assets/b75dc94d-1506-48e2-a171-805e85a148d3)
