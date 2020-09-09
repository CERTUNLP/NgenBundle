# When you are upgradint from previous version you need to manualy execute

```
 chmod +x $PATH_WEB/ngen_basic/src/NgenBundle/Utils/validateApiKey.php
 PASSVIEWER=`cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`
 curl -XPOST -H "Content-Type: application/json" -d '{"name":"Viewer","email":"viewer@localhost","login":"viewer","password":"$PASSVIEWER"}' -u $USER_GRAFANA:$PASS_GRAFANA $GRAFANA_HOST/api/admin/users
```
