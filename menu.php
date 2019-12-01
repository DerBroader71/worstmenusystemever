<?php

require_once __DIR__ . '/vendor/autoload.php';

// read the .ssh/config file
$filedata = file('.ssh/config');

// clean up the data
$filedata = array_map('trim', $filedata);
$filedata = array_filter($filedata);

// move data into the menu array
$i=0;
foreach($filedata as $line) {
    if (strpos($line, 'ost')) {
        if(strpos($line, 'ostname')) {
            $menu[$i-1]['desc'] = str_replace('Hostname ', '', $line);
        } else {
            $menu[$i]['name'] = str_replace('Host ', '', $line);
        }
    }
    $i++;
}

// reindex the array
$menudata = array_values($menu);

// drop the filedata array
unset($filedata);

// generate the menu
$menu = array();
foreach($menudata as $menuitem) {
        array_push($menu, array($menuitem["name"] => $menuitem["name"].' - '.$menuitem["desc"]));
}
array_push($menu, array('quit' => 'Quit to shell'));

// and then flatten it to a single dimension
$menu = flatten($menu);

// show the menu
while (true) {
        $choice = \cli\menu($menu, null, 'Choose a host');
        \cli\line();
        if ($choice == 'quit') {
            $execfile = './exec.sh';
            file_put_contents($execfile, "exit");
            break;
        }
        $execfile = './exec.sh';
        file_put_contents($execfile, "/usr/bin/ssh ${choice}");
        exit();
}

// a function to flatten an array to a single dimension
function flatten($array, $prefix = '') {
    $result = array();
    foreach($array as $key=>$value) {
        if(is_array($value)) {
            $result = $result + flatten($value, $prefix);
        }
        else {
            $result[$prefix . $key] = $value;
        }
    }
    return $result;
}
