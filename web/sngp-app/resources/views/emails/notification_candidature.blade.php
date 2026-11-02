<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notification SNGP-BAD</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    <style>
        body { font-family: 'Instrument Sans', Arial, sans-serif; background-color: #F4F7F6; color: #2C3E50; margin: 0; padding: 0; line-height: 1.6; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #F4F7F6; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { background-color: #1B4F72; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { font-family: 'Montserrat', sans-serif; font-size: 22px; margin: 0 0 5px 0; font-weight: 700; }
        .header p { margin: 0; font-size: 13px; opacity: 0.85; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .badge-success { display: inline-block; background-color: #27AE60; color: #ffffff; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 14px; }
        .badge-primary { display: inline-block; background-color: #2980B9; color: #ffffff; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 14px; }
        .badge-danger { display: inline-block; background-color: #E74C3C; color: #ffffff; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 14px; }
        .motif-box { background-color: #F8F9FA; border-left: 4px solid #E74C3C; padding: 15px; margin: 20px 0; border-radius: 0 6px 6px 0; font-size: 14px; color: #555; }
        .footer { background-color: #F4F7F6; text-align: center; padding: 20px; font-size: 12px; color: #7F8C8D; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="container" width="100%" cellpadding="0" cellspacing="0">
                    <!-- En-tête institutionnel -->
                    <tr>
                        <td class="header">
                            <h1>Système National de Gestion des Projets - BAD</h1>
                            <p>Cellule de Passation des Marchés Publics</p>
                        </td>
                    </tr>
                    
                    <!-- Corps du message -->
                    <tr>
                        <td class="content">
                            <p>Madame, Monsieur le Représentant de l'entreprise <strong>{{ $candidature->nom_candidat }}</strong>,</p>
                            
                            <p>Nous vous remercions pour l'intérêt que vous portez au projet SNGP-BAD dans le cadre de votre soumission pour le marché concerné (RCCM : <strong>{{ $candidature->numero_registre_commerce }}</strong>).</p>
                            
                            @if($candidature->statut_candidature === 'refusé')
                                <!-- CAS 1 : Candidature refusée (Dossier non conforme) -->
                                <p>Après l'analyse rigoureuse des pièces administratives et/ou techniques par la commission, nous vous informons que votre dossier a été classé : <span class="badge-danger">DOSSIER REFUSÉ / NON CONFORME</span>.</p>
                                
                                <p><strong>Motif de la décision :</strong></p>
                                <div class="motif-box">
                                    {{ $candidature->motif_statut ?? 'Non-conformité aux exigences du dossier d\'appel d\'offres.' }}
                                </div>

                            @elseif($candidature->statut_marche === 'tributaire')
                                <!-- CAS 3 : Attributaire du marché -->
                                <p>Nous avons l'immense plaisir de vous informer qu'à l'issue de l'évaluation financière et de l'arbitrage final, votre offre a été retenue et adjugée comme : <span class="badge-success">ATTRIBUTAIRE PROVISOIRE DU MARCHÉ</span>.</p>
                                <p>Notre secrétariat technique prendra contact avec vous dans les plus brefs délais pour les formalités de notification officielle et la signature de la convention.</p>

                            @elseif($candidature->statut_marche === 'rejeté')
                                <!-- CAS 4 : Dossier accepté mais marché non attribué -->
                                <p>Nous vous informons que votre dossier de candidature a bien été jugé conforme, mais que votre offre n'a pas été retenue pour l'attribution finale de ce marché : <span class="badge-danger">OFFRE NON RETENUE (NON ATTRIBUTAIRE)</span>.</p>
                                
                                <p><strong>Motif / Cause de la non-attribution :</strong></p>
                                <div class="motif-box">
                                    {{ $candidature->motif_statut ?? 'Offre conforme mais non classée la moins-disante par rapport à l\'attributaire retenu.' }}
                                </div>

                            @else
                                <!-- CAS 2 : Candidature acceptée et en attente -->
                                <p>Nous vous informons que votre dossier de candidature a été évalué et jugé <span class="badge-primary">CONFORME ET ADMIS</span> à l'étape d'évaluation finale.</p>
                                <p>Votre dossier est actuellement en cours d'arbitrage par le comité technique. Vous serez informé des suites de la procédure sous peu.</p>
                            @endif
                            
                            <p style="margin-top: 30px;">Nous vous remercions de nouveau pour votre participation au processus d'acquisition du SNGP-BAD.</p>
                        </td>
                    </tr>
                    
                    <!-- Pied de page -->
                    <tr>
                        <td class="footer">
                            <p>Ceci est un message automatique généré par la plateforme SNGP-BAD. Merci de ne pas y répondre directement.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>