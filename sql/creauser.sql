CREATE USER 'userApi'@'localhost' IDENTIFIED BY 'cXrpJBft5i';
GRANT ALL PRIVILEGES ON apiRedSocial.* TO 'userApi'@'localhost';
FLUSH PRIVILEGES;
/* % para todas las conexiones, sino localhost o uno especifico*/
ALTER USER 'userApi'@'localhost' IDENTIFIED WITH mysql_native_password BY 'cXrpJBft5i';