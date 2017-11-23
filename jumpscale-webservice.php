<?php
header('Content-Type: text/plain');

$branch = 'master';
$url = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if(end($url)) {
    $branch = end($url);
}

$basemodules = array('lib9', 'prefab9', 'ays9', 'portal9');
$modules = $basemodules;

if(isset($_GET['modules'])) {
    $usermod = explode(',', $_GET['modules']);
    $validmod = array();

    foreach($usermod as $mod)
        if(in_array($mod, $basemodules))
            $validmod[] = $mod;

    if(count($validmod))
        $modules = $validmod;

    if($_GET['modules'] == 'none')
        $modules = array();
}
?>
#!/bin/bash
set -e

# settings
export BRANCH="<?php echo $branch; ?>"

# base dependencies
apt-get update
apt-get install -y curl python3-pip git pkg-config libvirt-dev

# updating pip
pip3 install --upgrade pip

# this hack enable jumpscale to use /opt/ by default
touch /root/.iscontainer

# settigng up directories layout
mkdir -p /host
mkdir -p /opt/code/github/jumpscale
pushd /opt/code/github/jumpscale

# cloning source code
for target in core9 <?php echo join(' ', $modules); ?>; do
    git clone --depth=1 -b ${BRANCH} https://github.com/jumpscale/${target}
done

# installing core and plugins
for target in core9 <?php echo join(' ', $modules); ?>; do
    pushd ${target}
    pip3 install -e .
    popd
done

popd

# ensure jumpscale is well configured
js9 'print(j.core.dirs)'
