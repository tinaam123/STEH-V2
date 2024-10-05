<?php
session_start();

if (
  isset($_SESSION['user_id'])
  && isset($_POST['submit'])
  && $_POST['submit'] == 'log_out'
) {
  unset($_SESSION['user_id']);
}
