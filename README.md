# jumpscale-webservice
This is the source code of jumpscale.maxux.net

# Service
This service allows you to install jumpscale9 in a single bash line:
```
curl http://jumpscale.maxux.net/ | bash
```

# Customize
 - You can specify the branch as endpoint, eg: `http://jumpscale.maxux.net/9.3.0`
 - You can specify some modules, to not install the full package: `http://jumpscale.maxux.net/?modules=lib9,prefab9`

## Modules
You can specify theses modules:
 - lib9
 - prefab9
 - ays9
 - portal9

Only a valid modules will be added. The special module `none` is accepted and will not provided any module.
This is useful to install only `core9`. In any case, `core9` is installed.

You can of course use everything together: `http://jumpscale.maxux.net/9.3.0?modules=lib9`
