How To Install.

1. Extract this file into C:\inetpub\www\root\maybank\
   if maybank folder doesn't exists, create this folder.
2. change file .env and adjust it to the server setting, like Database & LDAP. example open .env.maybank
3. open terminal or CMD in root directory apps. and run " php artisan migrate ". this command for migrate database into server.
4. and then, run again "php artisan db:seed"
5. Ok. the apps ready to use.
