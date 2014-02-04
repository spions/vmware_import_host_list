<?php

class soapclientd extends soapclient
{
    public $action = false;
 
    public function __construct($wsdl, $options = array())
    {
        parent::__construct($wsdl, $options);
    }
 
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $resp = parent::__doRequest($request, $location, $action, $version, $one_way);
	return $resp;
    }
 
}
 

$client = new soapclientd('vimService.wsdl', array ('location' => 'https://host/sdk', 'trace' => 1));

    try   {
        $request = new stdClass();
        $request->_this = array ('_' => 'ServiceInstance', 'type' => 'ServiceInstance');
        $response = $client->__soapCall('RetrieveServiceContent', array((array)$request));
    } 
    catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    $ret = $response->returnval;
 
    try {
        $request = new stdClass();
        $request->_this = $ret->sessionManager;
        $request->userName = 'cactiuser';
        $request->password = 'password';
        $response = $client->__soapCall('Login', array((array)$request));
    } 
    catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
 
$ss1 = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$ss2 = new soapvar(array ('name' => 'DataCenterVMTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$a = array ('name' => 'FolderTraversalSpec', 'type' => 'Folder', 'path' => 'childEntity', 'skip' => false, $ss1, $ss2);
 
$ss = new soapvar(array ('name' => 'FolderTraversalSpec'), SOAP_ENC_OBJECT, null, null, 'selectSet', null);
$b = array ('name' => 'DataCenterVMTraversalSpec', 'type' => 'Datacenter', 'path' => 'vmFolder', 'skip' => false, $ss);

 
$res = null;
try
{
    $request = new stdClass();
    $request->_this = $ret->propertyCollector;
    $request->specSet = array (
        'propSet' => array (
            array ('type' => 'VirtualMachine', 'all' => 0, 'pathSet' => array ('name', 'guest.ipAddress', 'guest.guestState', 'runtime.powerState', 'config.hardware.numCPU', 'config.hardware.memoryMB','guest.guestFamily','guest.guestFullName','guest.guestOperationsReady','config.guestFullName')),
        ),
        'objectSet' => array (
            'obj' => $ret->rootFolder,
            'skip' => false,
            'selectSet' => array (
                new soapvar($a, SOAP_ENC_OBJECT, 'TraversalSpec'),
                new soapvar($b, SOAP_ENC_OBJECT, 'TraversalSpec'),
                ),
            )
        );
    $res = $client->__soapCall('RetrieveProperties', array((array)$request));
} catch (Exception $e)
{
    echo $e->getMessage();
}

    $res= (array) $res;
    $res = $res['returnval'];

//print_r($res);

       foreach ($res as $aRes) {
		$aRes = (array) $aRes;
		$propSet = $aRes['propSet'];

        	   $name=''; $ipAddress=''; $powerState=''; $numCPU=''; $memoryMB=''; $guestFamily=''; $GuestOsIdentifier=''; 
		    $guestFullName = ''; $configguestFullName ='';

	           foreach ($propSet as $apropSet) {
		        $apropSet = (array) $apropSet;

			if ($apropSet['name']=='name') {$name=$apropSet['val'];}
			if ($apropSet['name']=='guest.ipAddress') {$ipAddress=$apropSet['val'];}
			if ($apropSet['name']=='runtime.powerState') {$powerState=$apropSet['val'];}
			if ($apropSet['name']=='config.hardware.numCPU') {$numCPU=$apropSet['val'];}
			if ($apropSet['name']=='config.hardware.memoryMB') {$memoryMB=$apropSet['val'];}
			if ($apropSet['name']=='guest.guestFamily') {$guestFamily=$apropSet['val'];}
			if ($apropSet['name']=='guest.guestFullName') {$guestFullName=$apropSet['val'];}
			if ($apropSet['name']=='config.guestFullName') {$configguestFullName=$apropSet['val'];}

		    }
		    $resu[] = array ('name'=>$name,'ipAddress'=>$ipAddress, 'powerState'=>$powerState,'numCPU'=>$numCPU, 'memoryMB'=>$memoryMB,'guestFamily'=>$guestFamily,'guestFullName'=>$guestFullName,'configguestFullName'=>$configguestFullName);

            }

print_r($resu);
