<?php

/*if($_SERVER['REMOTE_ADDR'] != '::1') {
    $inRegister = true;
    include 'index.php';
    die();
  } */
  
  if(isset($_GET['username'])) {
    function sendBack($func_value) {
      $func_data = array('false' => 'REGISTER', 'fail' => 'DATABASE_ERROR', 'true' => 'USERNAME_TAKEN');
      include "Pages/{$func_data[$func_value]}.page.php";
    }
    
    include 'checkName.php';
    die();
  }
  
  from ;include 'settings.php' ;uses ;{
    $pMin = PLAYER_MINLEN;
    $pMax = PLAYER_MAXLEN;
    $pChr = PLAYER_MAXLEN;
    
    $aMin = PASSWORD_MINLEN;
    $aMax = PASSWORD_MAXLEN;
    
    $eMin = EMAIL_MINLEN;
    $eMax = EMAIL_MAXLEN;
  };

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
    
    <title>iCPPS :: Registration</title>
    
    <link type='text/css' href='CSS/ui-lightness/jquery-ui-1.8.2.custom.css' rel='stylesheet' />  
    <link type='text/css' href='CSS/register.css' rel='stylesheet' />  
    
    <script type='text/javascript' src='JS/MD5.js'></script>
    <script type='text/javascript' src='JS/jquery-1.4.2.min.js'></script>

    <script type='text/javascript' src='JS/jquery-ui-1.8.2.custom.min.js'></script>
    
    <script type='text/javascript'>
    
      function LTrim(value) {
      	var re = /\s*((\S+\s*)*)/;
      	return value.replace(re, "$1");
      }
      
      function RTrim(value) {
      	var re = /((\s*\S+)*)\s*/;
      	return value.replace(re, "$1");
      }
      
      function trim(value) {
      	return LTrim(RTrim(value));
      }
    
      var moderatorTimer = 0;
      var isLoggedIn = false;
      var suggestValues = {
        playerName:   'Playername',
        passwordA:    '',
        passwordB:    '',
        emailAddress: 'EMail@Address.com',
        recommended:  'Who told you about this?'
      };
      
      var states = {
        noticePasswords:  0,
        noticePlayerName: 0,
        noticeEMail:      0
      };
      
      function updateStatus(classString, messageString) {
        $('#statusBar').removeClass('ui-state-error');
        $('#statusBar').removeClass('ui-state-highlight');
        $('#statusBar').addClass(classString);
        
        var iconString = classString == 'ui-state-error' ? 'ui-icon-alert' : 'ui-icon-info';
        $('#statusBar').html('<p><span class="ui-icon ' + iconString + '" style="float: left; margin-right: .3em;"></span>' + messageString + '</p>');
      }
      
      function showLoader(message) {
        $('#content').html('<div align=\'center\'><img src=\'Images/Loader.gif\' /><br />' + message + '</div>');
      }
      
      function loadContent(url, container) {
        url = url.split('?');
        data = url[1];
        url = url[0];
        $.ajax({
          url: url,
          data: data,
          success: function(data) {
            $(container).html(data);
          }
        });
      }
      
      function updateNotice(fieldID, fieldData, fieldMessage) {
        states[fieldID] = Number(fieldData == 'fieldNoticeFail');
        fieldID = '#' + fieldID;
        
        $(fieldID).removeClass('fieldNoticeOkay');
        $(fieldID).removeClass('fieldNoticeFail');
        
        $(fieldID).addClass(fieldData);
        
        $(fieldID).html(fieldMessage);
      }
      
      $(function() {
        $('#playerName, #recommended').keyup(function() {
          var playerName = this.value;
          var noticeID = this.id == 'playerName' ? 'noticePlayerName' : 'noticeEMail';
          
          if(playerName.length == 0)
           if(this.id == 'recommended') return updateNotice(noticeID, 'fieldNoticeOkay', 'You don\'t have to edit that Field, but it\'s recommended!');
           else return updateNotice(noticeID, 'fieldNoticeFail', 'Please enter a Username!');
          
          if(playerName.length < 3) return updateNotice(noticeID, 'fieldNoticeFail', 'The PlayerName is too short! 3 Chars at Minimum!');
          if(playerName.length > 12) return updateNotice(noticeID, 'fieldNoticeFail', 'The PlayerName is too long! 12 Chars at Maximum!');
          
          var count = 0;
          for(var i = 0; i < playerName.length; ++i) if((chr = playerName.charCodeAt(i)) && (chr > 64 && chr < 91 || chr > 96 && chr < 123)) ++count;
          if(!count) return updateNotice(noticeID, 'fieldNoticeFail', 'The PlayerName has to contain atleast one letter!');
          
          return updateNotice(noticeID, 'fieldNoticeOkay', 'The PlayerName is okay :)');
        }).trigger('keyup').blur(function() {
          if(states.noticePlayerName) return;
          $.ajax({
            url:  'checkName.php',
            data: 'username=' + this.value,
            success: function(data) {
              if(data == 'true')  return updateNotice('noticePlayerName', 'fieldNoticeFail', 'Sorry, that PlayerName is already taken!');
              if(data == 'fail')  return updateNotice('noticePlayerName', 'fieldNoticeFail', 'Sorry, we have no Database Connection currently!');
              if(data == 'false') return updateNotice('noticePlayerName', 'fieldNoticeOkay', 'The PlayerName is okay and not taken yet :)');
              alert(
               ['Debug TraceBack',
                ' at iCPPS',
                '  at Register.php',
                '   at AJAX.success Callback',
                '    called with Parameter',
                '    #0: [' + typeof(data) + '] ' + data,
                '     at checkName.php?username=...',
                '',
                ''].join("\n"));
              return updateNotice('noticePlayerName', 'fieldNoticeFail', 'Something is wrong!');
            }
          });
        });
        $('#passwordA, #passwordB').keyup(function() {
          
          this.value = trim(this.value);
          if(this.value.length == 0)
           if(this.id == 'passwordB' && $('#passwordA').val().length != 0) return updateNotice('noticePasswords', 'fieldNoticeFail', 'You have to repeat the Password!');
           else return updateNotice('noticePasswords', 'fieldNoticeFail', 'You have to enter a Password!');
          
          if(this.id == 'passwordB' && $('#passwordA').val() != $('#passwordB').val())
           return updateNotice('noticePasswords', 'fieldNoticeFail', 'The Passwords don\'t match!');
          
          if(this.value.length < 6) return updateNotice('noticePasswords', 'fieldNoticeFail', 'The Password is too short! 6 Chars at Minimum!');
          if(this.value.length > 32) return updateNotice('noticePasswords', 'fieldNoticeFail', 'The Password is too long! 32 Chars at Maximum!');
          
          if($('#passwordB').val().length == 0) return updateNotice('noticePasswords', 'fieldNoticeFail', 'You have to repeat the Password!');
          if(this.id == 'passwordA' && $('#passwordA').val() != $('#passwordB').val())
           return updateNotice('noticePasswords', 'fieldNoticeFail', 'The Passwords don\'t match!');
            
          return updateNotice('noticePasswords', 'fieldNoticeOkay', 'The Passwords are okay :)');
        }).trigger('keyup');
        $('#emailAddress').keyup(function() {
          this.value = trim(this.value);
          
          var email = this.value;
          
          if(email.length < 6) return updateNotice('noticeEMail', 'fieldNoticeFail', 'The EMail Address is too short! 6 Chars at Minimum!');
          if(email.length > 128) return updateNotice('noticeEMail', 'fieldNoticeFail', 'The EMail Address is too long! 128 Chars at Maximum!');
          
          if(email.split('@').length != 2) return updateNotice('noticeEMail', 'fieldNoticeFail', 'The EMail Address is invalid! It has to contain exactly <b>one</b> @!');
          if(email.split('@')[1].split('.').length < 2) return updateNotice('noticeEMail', 'fieldNoticeFail', 'The EMail Address is invalid! The Domain is wrong!');
          
          var emailName   = email.split('@')[0];
          var emailDomain = email.split('@')[1].split('.');
          var emailTLD    = emailDomain.pop();
          emailDomain = emailDomain.join('.');
          
          if(emailName.length < 1)   return updateNotice('noticeEMail', 'fieldNoticeFail', 'You have to specify a Username in the EMail Address!');
          if(emailDomain.length < 1) return updateNotice('noticeEMail', 'fieldNoticeFail', 'You have to specify a Domain in the EMail Address!');
          if(emailTLD.length < 2)    return updateNotice('noticeEMail', 'fieldNoticeFail', 'You have to specify a valid TLD in the EMail Address!');
          
          return updateNotice('noticeEMail', 'fieldNoticeOkay', 'The EMail is okay :)');
        }).trigger('keyup');
        $('document').ready(function() {
          updateStatus('ui-state-highlight', '<strong>Welcome!</strong> To Register for iCP click the "Register" Button!');
          
          for(var i in suggestValues) $('#' + i).addClass('suggestBox');
          $('.suggestBox').focus(function() {
            if(this.value == suggestValues[this.id]) this.value = '';
            this.style.color = '#000000';
          });
          $('.suggestBox').blur(function() {
            if(this.value == '') this.value = suggestValues[this.id];
            if(this.value == suggestValues[this.id]) this.style.color = '#DADADA';
          });
          $('.suggestBox').trigger('blur');
        });
        $('#registerBox').dialog({
          modal:    true,
          autoOpen: false,
          width:    320,
          beforeclose: function() { updateStatus('ui-state-highlight', '<strong>Welcome!</strong> Registration aborted!'); },
          buttons: {
            'Submit': function() {
              var sum = 0;
              for(var i in states) sum += states[i];
              
              if(sum) {
                var s = sum == 1 ? '' : 's';
                var is = sum == 1 ? 'is' : 'are';
                var error = 'There ' + is + ' still ' + sum + ' Mistake' + s + ' in the Regristration Form!';
                
                return (updateStatus('ui-state-error', '<strong>Regristration failed:</strong> ' + error) | alert(error)) && false;
              } else {
                $(this).dialog('close');
                $(this).dialog('close');
                updateStatus('ui-state-highlight', '<strong>Status:</strong> Sending Regristration...');
                loadContent('register.php?' +
                'username=' + $('#playerName').val() +
                '&password=' + $('#passwordA').val() +
                '&email=' + $('#emailAddress').val() +
                '&color=' + $('#color').val(), '#content');
              }
            }, 
            'Cancel': function() {
              $(this).dialog('close'); 
            } 
          }
        });
        $('#registerLink').click(function() {
          $('#registerBox').dialog('open');
          return false;
        });
        $('#registerLink, ul#icons li').hover(
          function() { $(this).addClass('ui-state-hover'); }, 
          function() { $(this).removeClass('ui-state-hover'); }
        );        
      });
      
    </script>

  <body>
    <div class='ui-widget'><div id='statusBar' class='ui-corner-all'></div></div>
    <div align='right'><a href='#' id='registerLink' class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-newwin'></span>Register</a></div>
    <div id='registerBox' title='Register for iCPPS'>
      <div id='noticePlayerName' class='fieldNotice'></div>
      <input type='text' id='playerName' maxlength='<?= $pMax ?>' /><br />
      <div id='noticePasswords' class='fieldNotice'></div>
      <input type='password' id='passwordA' maxlength='<?= $aMax ?>' /><br />
      <input type='password' id='passwordB' maxlength='<?= $aMax ?>' /><br />
      <div id='noticeEMail' class='fieldNotice'></div>
      <input type='text' id='emailAddress' maxlength='<?= $eMax ?>' /><br />
      <input type='text' id='recommended'  maxlength='<?= $pMax ?>'  /><br />
      <div class='fieldNotice'>If you don't pick a Color, we will surprise you by picking one randomly!</div>
      <select id='color'>
        <option value='0'>Pick a Color</option>
        <option value='1'>Blue</option>
        <option value='2'>Green</option>
        <option value='3'>Pink</option>
        <option value='4'>Black</option>
        <option value='5'>Red</option>
        <option value='6'>Orange</option>
        <option value='7'>Yellow</option>
        <option value='8'>Dark Purple</option>
        <option value='9'>Brown</option>
        <option value='10'>Peach</option>
        <option value='11'>Dark Green</option>
        <option value='12'>Light Blue</option>
        <option value='13'>Lime Green</option>
        <option value='15'>Aqua</option>
      </select>
    </div>
    <div id='content' class='ui-corner-all'>
	<?php
	?>
      Registration page!
	  <br>
	  <br><br><br>

    </div>
  </body>
</html>