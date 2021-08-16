<?php
// get the id parameter from the request
header('Content-Type: application/json');
$id = intval($_GET['id']);
$db = new mysqli('localhost','cs143','','cs143');
if($db->connect_errno > 0)
{ 
    die('Connection to Database Error: [' . $db->connect_error . ']');
}
$lDet = "SELECT * FROM Laureate WHERE (id = '{$id}')";
$l_res = $db->query($lDet);
$row = $l_res->fetch_assoc();
$name = $row["name"];
$familyName = $row["familyName"];
$gender = $row["gender"];
$date = $row["bDate"];
$city = $row["city"];
$country = $row["country"];
$l_res->free();

$prizeArr = array();

$prizeDet = "SELECT * FROM nobelPrizes WHERE (lid='{$id}')";
$p_res = $db->query($prizeDet);
while($p_row = $p_res->fetch_assoc())
{
    $currPrize = (object)[];
    $currPrize->awardYear = strval($p_row["awardYear"]);
    $currPrize->category->en = strval($p_row["category"]);
    if(strval($p_row["sortOrder"]) != '')
        $currPrize->sortOrder = strval($p_row["sortOrder"]);
    if(strval($p_row["sortOrder"]) != '')
        $currPrize->portion = strval($p_row["portion"]);
    if(strval($p_row["dateAwarded"]) != '0000-00-00' && strval($p_row["dateAwarded"]) != '')
        $currPrize->dateAwarded = strval($p_row["dateAwarded"]);
    if(strval($p_row["prizeStatus"]) != '')
        $currPrize->prizeStatus = strval($p_row["prizeStatus"]);

    if(strval($p_row["motivation"]) != '')
        $currPrize->motivation->en = strval($p_row["motivation"]);
    if(strval($p_row["prizeAmount"]) != '')
        $currPrize->prizeAmount = strval($p_row["prizeAmount"]);

    $affil = array();
    $affilDet = "SELECT * FROM affiliations WHERE (awardYear ='{$p_row["awardYear"]}' AND category='{$p_row["category"]}' 
    AND lid='{$p_row["lid"]}')";
    $affil_res = $db->query($affilDet);
    if($affil_res->num_rows >= 1)
    {
        while($a_row = $affil_res->fetch_assoc())
        {
            $currAffil = (object)[];
            if(strval($a_row["name"]) != '')
                $currAffil->name->en = strval($a_row["name"]);
            if(strval($a_row["city"]) != '')
                $currAffil->city->en = strval($a_row["city"]);
            if(strval($a_row["country"]) != '')
                $currAffil->country->en = strval($a_row["country"]);
            array_push($affil, $currAffil);
        }
        $affil_res->free();
        $currPrize->affiliations = $affil;
    }   
    array_push($prizeArr,$currPrize);
}
$p_res->free();
$output = (object)[];
$output->id = strval($id);
if($gender == "male" || $gender == "female")
{
    $output->givenName = (object)["en" => strval($name)];
    $output->familyName = (object)["en" => strval($familyName)];
    if(strval($gender) != '')
        $output->gender = strval($gender);
    if(strval($date) != '0000-00-00' && strval($date) != '')
        $output->birth->date = strval($date);
    if(strval($city) != '')
        $output->birth->place->city->en = strval($city);
    if(strval($country) != '')
        $output->birth->place->country->en = strval($country);
}
else
{
    $output->orgName->en = strval($name);
    if(strval($date) != '0000-00-00' && strval($date) != '')
        $output->founded->date = strval($date);
    if(strval($city) != '')
        $output->founded->place->city->en = strval($city);
    if(strval($country) != '')
        $output->founded->place->country->en = strval($country);
}
$output->nobelPrizes = $prizeArr;
echo json_encode($output, JSON_PRETTY_PRINT);
$db->close();
?>
