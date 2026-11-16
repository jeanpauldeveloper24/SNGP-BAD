import 'package:flutter/material.dart';

class Guest extends StatelessWidget {
  final String prestataireName;
  final VoidCallback onProfilePressed;

  const Guest({
    super.key,
    required this.prestataireName,
    required this.onProfilePressed,
  });

  // Couleurs de la charte graphique SNGP-BAD
  static const Color primaryColor = Color(0xFF1B4F72); // Bleu Cobalt Profond
  static const Color textDark = Color(0xFF2C3E50); // Noir Anthracite

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 12.0),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: textDark.withOpacity(0.05),
            blurRadius: 4,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          // Logo de l'application
          ClipRRect(
            borderRadius: BorderRadius.circular(8),
            child: Image.asset(
              'images/icon_sngp.jpeg',
              height: 40,
              width: 40,
              fit: BoxFit.cover,
            ),
          ),
          const SizedBox(width: 12),
          
          // Nom / Infos du prestataire connecté
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'Espace Prestataire',
                  style: TextStyle(
                    fontFamily: 'Inter',
                    fontSize: 11,
                    color: Color(0xFF6B7280),
                  ),
                ),
                Text(
                  prestataireName,
                  style: const TextStyle(
                    fontFamily: 'Montserrat',
                    fontSize: 14,
                    fontWeight: FontWeight.bold,
                    color: primaryColor,
                  ),
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),
          
          // Bouton pour accéder au profil de l'utilisateur
          IconButton(
            icon: const Icon(Icons.account_circle, color: primaryColor, size: 30),
            onPressed: onProfilePressed,
            tooltip: 'Mon Profil',
          ),
        ],
      ),
    );
  }
}