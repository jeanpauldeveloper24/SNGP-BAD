import 'package:flutter/material.dart';

class PaiementsScreen extends StatelessWidget {
  const PaiementsScreen({super.key});

  static const Color primaryColor = Color(0xFF1B4F72);
  static const Color secondaryColor = Color(0xFF2E86C1);
  static const Color accentColor = Color(0xFF27AE60);
  static const Color textDark = Color(0xFF2C3E50);
  static const Color bgLight = Color(0xFFF4F7F6);

  @override
  Widget build(BuildContext context) {
    return Material(
      color: bgLight,
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text(
                  'Décomptes & Paiements',
                  style: TextStyle(fontFamily: 'Montserrat', fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor),
                ),
                ElevatedButton.icon(
                  style: ElevatedButton.styleFrom(
                    backgroundColor: primaryColor,
                    foregroundColor: Colors.white,
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                  ),
                  onPressed: () {
                    ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text('Ouverture du formulaire de nouveau décompte...')),
                    );
                  },
                  icon: const Icon(Icons.add, size: 18),
                  label: const Text('Nouveau', style: TextStyle(fontFamily: 'Montserrat', fontSize: 12)),
                ),
              ],
            ),
            const SizedBox(height: 16),

            // Liste des décomptes soumis
            _buildDecompteCard(
              title: 'Décompte Partiel N°1',
              montant: '450 000 000 FCFA',
              date: '10/10/2026',
              status: 'Validé',
              statusColor: accentColor,
            ),
            const SizedBox(height: 12),
            _buildDecompteCard(
              title: 'Décompte Partiel N°2',
              montant: '300 000 000 FCFA',
              date: '05/11/2026',
              status: 'En attente',
              statusColor: secondaryColor,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDecompteCard({
    required String title,
    required String montant,
    required String date,
    required String status,
    required Color statusColor,
  }) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: secondaryColor.withOpacity(0.2)),
        boxShadow: [
          BoxShadow(color: textDark.withOpacity(0.03), blurRadius: 8, offset: const Offset(0, 3)),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(title, style: const TextStyle(fontFamily: 'Montserrat', fontSize: 14, fontWeight: FontWeight.bold, color: textDark)),
              const SizedBox(height: 4),
              Text('Soumis le $date', style: TextStyle(fontFamily: 'Inter', fontSize: 11, color: textDark.withOpacity(0.6))),
              const SizedBox(height: 8),
              Text(montant, style: const TextStyle(fontFamily: 'Montserrat', fontSize: 13, fontWeight: FontWeight.bold, color: primaryColor)),
            ],
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
            decoration: BoxDecoration(
              color: statusColor.withOpacity(0.1),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              status,
              style: TextStyle(fontFamily: 'Inter', fontSize: 11, fontWeight: FontWeight.bold, color: statusColor),
            ),
          ),
        ],
      ),
    );
  }
}