+"$" comme seperateur dans push_zemail_queue.sh

ALTER TABLE `autoemailtemplate` CHANGE `message` `message` VARCHAR(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

INSERT INTO `autoemailtemplate` (`name`, `message`, `type`, `status`) VALUES
('ACTIVATION DE COMPTE ECOMED24', "<table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' style='width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
  <tr>
    <td
      style='font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
      <table class='email-content' width='100%' cellpadding='0' cellspacing='0'
        style='width: 100%;margin: 0;padding: 0;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
       
        <tr>
          <td class='email-masthead'
            style='padding: 25px 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <a class='email-masthead_name'
              style='color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                ecoMed24
            </a>
          </td>
        </tr>
        <tr>
          <td class='email-body' width='100%'
            style='width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <table class='email-body_inner' width='570' cellpadding='0' cellspacing='0'
              style='width: 570px;margin: 0 auto;padding: 0;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
              <tr>
                <td class='content-cell'
                  style='padding: 35px;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                  <h1
                    style='margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Vérification de votre adresse e-mail</h1>
                  <p
                    style='margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    ecoMed24 vous invite à activer votre compte.</p>
                  <table class='body-action' width='100%' cellpadding='0' cellspacing='0'
                    style='width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    <tr>
                      <td
                        style='font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                        <div
                          style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                            <a href='{reset_url}' class='button button--blue'
                            style='color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'><b
                              style='font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                              Activez votre compte</b></a>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <p
                    style='margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Merci,<br>L'équipe ecoMed24</p>
                  <table class='body-sub'
                    style='margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    <tr>
                      <td
                        style='font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                        <p class='sub'
                          style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                          Si le bouton ci-dessus ne fonctionne pas pour vous,
                          veuillez copier et coller le lien suivant dans un navigateur.
                        </p>
                        <p class='sub'
                          style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                          <a href='{reset_url}'
                            style='color: #0854a5;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>{activation_url}</a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td
            style='font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <table class='email-footer' width='570' cellpadding='0' cellspacing='0'
              style='width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
              <tr>
                <td class='content-cell'
                  style='padding: 35px;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                  <p class='sub center'
                    style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>", 'account_activation_by_email', 'Inactive');