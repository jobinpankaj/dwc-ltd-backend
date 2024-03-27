<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Retailer Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <style type="text/css">
    a[x-apple-data-detectors] {color: inherit !important;}
  </style>
</head>
<body style="margin: 0; padding: 0;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
      <td style="padding: 20px 0 30px 0;border-radius: 5px;">

        <table style="border-collapse: collapse;border: 1px solid #a5a5a5;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody><tr>
            <td style="padding: 20px 0 20px 0;background-color: #9370DB;" align="center">
              <img src="https://buvonslocal.pro/static/media/logo.8ebedae0d777ed358225d520cbe8b869.svg" alt="Buvons Local PRO" style="display: block; max-width: 120px;" width="120" height="100">
              <!-- {{ asset('images/logo.svg') }} -->
            </td>  
          </tr>
          <tr>
            <td style="padding: 40px 30px 40px 30px;background-color: #fff;">
              <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="color: #050030;font-family: Arial, sans-serif;text-align: start;">
                  <p style="font-size: 17px; margin: 0;margin-bottom:30px;">- English message will follow - </p>
                    <h1 style="font-size: 24px; margin: 0;">Bonjour  <?php if(!empty($details['name'])){ echo $details['name'].","; }else{?> partenaire de  l’industrie!,<?php } ?></h1>
                  </td>
                </tr>
                <tr>  
                  <td style="color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                  <p>Nous prenons quelques instants de votre précieux temps pour vous annoncer la mise en service de la plateforme BUVONS LOCAL PRO (BLP)!</p>
                  <p>Nous sommes ravis de vous présenter une opportunité exclusive de rejoindre Buvons Local PRO, notre nouvelle plateforme E.R.P. innovatrice, conçue spécialement pour les détaillants passionnés par la bière artisanale.</p>
                  <p>En tant qu'acteur clé du marché, votre présence sur Buvons Local PRO vous permettra d'accéder directement à vos brasseurs favoris, de découvrir des produits spécialisés et de centraliser vos paiements, optimisant ainsi votre temps et vos efforts comptables. De plus, vous bénéficierez de promotions exclusives et des dernières nouveautés du secteur.</p>
                  <p>Votre sélection pour cette invitation exclusive est le fruit de notre collaboration réussie avec notre société sœur, Distribution Bucké, dont vous êtes déjà un partenaire estimé. Nous sommes convaincus que Buvons Local PRO deviendra votre plateforme privilégiée pour vos gestions d'achat et paiements liés à l'industrie brassicole.</p>
                  <p>Votre compte est déjà créé. Activez-le avec le mot de passe fourni pour profiter des avantages.</p> 
                  <?php echo $details['body']; ?>
                  <p>Validez et complétez votre profil sur <a style="color: #2155be;" href="https://buvonslocal.pro/retailer/login">https://buvonslocal.pro/retailer/login</a> dès aujourd'hui pour participer à cette aventure innovante. </p>
                  <p>Au plaisir de travailler avec vous !</p>
                  <p>L’équipe de Buvons Local Pro</p>
                    <?php //echo $details['body']; ?>
                  </td>
                </tr>
                <tr>
                  <td style="color: #594f51; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0;">+1 (450) 446-9090</p>
                    <p style="margin: 0;">support@buvonslocal.ca</p>
                    <p style="margin: 0;"><a style="color: #2155be;" href="https://buvonslocal.pro">https://buvonslocal.pro</a></p>
                    <p style="margin: 0;">101-1405 Graham-Bell.</p>
                    <p style="margin: 0;">Qc. J4B 6A1</p>
                  </td>
                </tr>
                </tbody></table>
            </td>
          </tr>
                <!---english---------->
                <tr>
            <td style="padding: 40px 30px 40px 30px;background-color: #fff;">
              <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody><tr>
                  <td style="color: #050030;font-family: Arial, sans-serif;text-align: start;">
                    <h1 style="font-size: 24px; margin: 0;">Hello  <?php if(!empty($details['name'])){ echo $details['name'].","; } else { ?> industry partner!, <?php } ?></h1>
                  </td>
                </tr>
                <tr>
                  <td style="color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                  <p> We are taking a moment of your valuable time to announce the launch of the BUVONS LOCAL PRO (BLP) platform!</p>
                  <p>We are excited to share with you an exclusive opportunity to join Buvons Local PRO, an innovative E.R.P. platform, specially designed for retailers passionate about craft beer (buying and selling).</p>
                  <p>As a key player in the craft market place, your presence on Buvons Local PRO will allow you direct access to your favorite brewers, to discover specialized products, and to centralize your payments, thus optimizing your time and accounting efforts. In addition, you will benefit from exclusive promotions and the latest news in the sector.</p>
                  <p>We are sending this exclusive invitation to you, as the result of your collaboration with our sister company, Distribution Bucké; of which, you are already an esteemed partner. 
                  We are confident that Buvons Local PRO will become your preferred platform for managing your artisanal beer purchases and payments. </p>
                  <p>Your account has already been created.  Use the password here provided and validate your account to enjoy the benefits.</p>
                  <?php echo $details['body']; ?>
                  <p>Validate and complete your profile at <a style="color: #2155be;" href="https://buvonslocal.pro/retailer/login">https://buvonslocal.pro/retailer/login</a> today to be part of this innovative adventure.</p>
                  <p>Looking forward to working with you!</p>
                  </td>
                </tr>
                <tr>
                  <td style="color: #594f51; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                  <p style="margin: 0;">The Buvons Local Pro Team</p>
                    <p style="margin: 0;">+1 (450) 446-9090</p>
                    <p style="margin: 0;">support@buvonslocal.ca</p>
                    <p style="margin: 0;"><a style="color: #2155be;" href="https://buvonslocal.pro">https://buvonslocal.pro</a></p>
                    <p style="margin: 0;">101-1405 Graham-Bell.</p>
                    <p style="margin: 0;">Qc. J4B 6A1</p>
                  </td>
                </tr>



              </tbody></table>
            </td>
          </tr>
          <tr>
            <td style="padding: 16px 30px;background-color: #9370DB;">
                <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody><tr>
                    <td style="color: #000; font-family: Arial, sans-serif; font-size: 16px; text-align: center;">
                      <p style="margin: 0;">Buvons Local PRO @2024</p>
                    </td>
                    
                  </tr>
                </tbody></table>  
            </td>
          </tr>
        </tbody></table>

      </td>
    </tr>
  </tbody></table>



</body>
</html>

