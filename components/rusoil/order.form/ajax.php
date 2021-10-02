<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(dirname(__FILE__).'/templates/.default/template.php');

//проверка наличия события. Если нет, то создаю
$event_type = 'ORDER_FORM_TEST';
$event_filter = array(
    "TYPE_ID" => $event_type,
    "LID"     => "s1"
    );
$event_types = [];
$event_list = CEventType::GetList($event_filter);
if ($event = $event_list->Fetch())
{
    $event_types[] = $event;
}
if(empty($event_types)) {
    $order_event = new CEventType;
    $order_event->Add(array(
        "EVENT_NAME"    => $event_type,
        "NAME"          => "Создана новая заявка",
        "LID"           => "s1",
        "DESCRIPTION"   => "
            #MESSAGE# - Состав заявки
            #EMAIL_TO# - От кого
            #EMAIL_FROM# - Кому
            "
        ));
}
//проверка наличия почтового шаблона. Если нет, то создаю
$templates = CEventMessage::GetList($by="site_id", $order="desc", Array(
    "TYPE_ID"       => array($event_type),
    "SITE_ID"       => "s1",
));
if(!$template = $templates->GetNext())
{
    $fields = [
        "ACTIVE" => 'Y',
        "EVENT_NAME" => $event_type,
        "LID" => array("s1"),
        "BODY_TYPE" => 'html',
        "EMAIL_FROM" => "#EMAIL_FROM#",
        "EMAIL_TO" => "#EMAIL_TO#",
        "MESSAGE" => "#MESSAGE#",
    ];
    $emess = new CEventMessage;
    $emess->Add($fields);
}
//подготовка файлов
if($_FILES['file']) {
    $uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/upload/order';
    if(!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777);
    }
    foreach($_FILES['file'] as $key => $index) {
        for($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $files[$i][$key] =  $_FILES['file'][$key][$i];
        }
    } 
    foreach($files as $file) {
        $fid = CFile::SaveFile(
            $file,
            '/order',
            false, 
            false,
            $dirAdd='',
            true
        );
        $file_ids[] = $fid;
    }
}
//тут нужно было бы передавать текстовые значения склада, категории и тд. и тп., но их нет в БД) поэтому передаю только их ID
$message = Loc::getMessage('new_order').".<br>";
foreach($_POST as $key => $value) {
    if(!is_array($value) && $value != '') {
        $message .= Loc::getMessage($key).': '.$value."<br>";
    } else {
        $order_opts[] = array_merge([Loc::getMessage($key)], $value);
    }
}
for($i = 0; $i < count($order_opts[0]); $i++) {
    $order_rows[$i] = array_column($order_opts, $i);
}
$message .= '<table border="1">';
    for($i = 0; $i < count(($order_rows)); $i++) {
        $message .= '<tr>';
            if($i == 0) {
                foreach($order_rows[$i] as $value){
                    $message .= "<th>$value</th>";
                }          
            } else {
                foreach($order_rows[$i] as $value){
                    $message .= "<td>$value</td>";
                }
            }
            $message .= "</tr>";
    }
$message .= "</table>";
//отправка письма. 
$send_email = \Bitrix\Main\Mail\Event::sendImmediate(array(
    "EVENT_NAME" => $event_type, 
    "LID" => "s1", 
    "C_FIELDS" => array( 
        "MESSAGE" => $message,
        "EMAIL_TO" => Option::get("main", "email_from"), 
        "EMAIL_FROM" => Option::get("main", "email_from"), 
    ),
    "FILE" => $file_ids,
));
if($send_email != 'Y') {
    echo 'Что-то пошло не так.';
} else {
    echo 'Заявка успешно отправлена';
}