import 'package:flutter/material.dart';

class AccueilScreen extends StatelessWidget {
  final Function(int)? onNavigateTab;

  const AccueilScreen({super.key, this.onNavigateTab});

  // Couleurs de la charte graphique SNGP-BAD
  static const Color primaryColor = Color(0xFF1B4F72); // Bleu Cobalt Profond
  static const Color secondaryColor = Color(0xFF2E86C1); // Bleu Ardoise
  static const Color accentColor = Color(0xFF27AE60); // Vert Émeraude
  static const Color textDark = Color(0xFF2C3E50); // Noir Anthracite
  static const Color bgLight = Color(0xFFF4F7F6); // Gris Perle Très Clair

  @override
  Widget build(BuildContext context) {
    return Material(
      color: bgLight,
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // En-tête de bienvenue / Marché assigné
            Container(
              width: double.infinity,
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: secondaryColor.withOpacity(0.2)),
                boxShadow: [
                  BoxShadow(
                    color: textDark.withOpacity(0.04),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text(
                        'Marché Actif',
                        style: TextStyle(fontFamily: 'Montserrat', fontSize: 12, fontWeight: FontWeight.bold, color: secondaryColor),
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                        decoration: BoxDecoration(
                          color: accentColor.withOpacity(0.1),
                          borderRadius: BorderRadius.circular(20),
                        ),
                        child: const Text(
                          'En Cours',
                          style: TextStyle(fontFamily: 'Inter', fontSize: 11, fontWeight: FontWeight.bold, color: accentColor),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 8),
                  const Text(
                    'REG1-COM1-ENE1-TRV1-001',
                    style: TextStyle(fontFamily: 'Montserrat', fontSize: 16, fontWeight: FontWeight.bold, color: textDark),
                  ),
                  const SizedBox(height: 4),
                  const Text(
                    'Projet d\'Électrification Rurale et d\'Adduction d\'Eau Solaire dans le Poro',
                    style: TextStyle(fontFamily: 'Inter', fontSize: 13, color: textDark),
                  ),
                  const SizedBox(height: 16),
                  const LinearProgressIndicator(
                    value: 0.35,
                    backgroundColor: bgLight,
                    color: accentColor,
                    minHeight: 8,
                  ),
                  const SizedBox(height: 8),
                  const Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text('Avancement physique : 35%', style: TextStyle(fontFamily: 'Inter', fontSize: 12, color: textDark)),
                      Text('Budget : 1 513 000 000 FCFA', style: TextStyle(fontFamily: 'Montserrat', fontSize: 12, fontWeight: FontWeight.bold, color: primaryColor)),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}