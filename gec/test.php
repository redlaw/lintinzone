<?php
 try
 {
  echo 'About to send mail.<br />';
  mail('tung121089@gmail.com', 'LintinZone: Thư xác nhận từ LintinZone', 'Bạn đã trở thành một thành viên LintinZone');
  echo 'Mail sent';
 }
 catch (Exception $exc)
 {
  echo 'Error: ';
  var_dump($exc);
 }
?>