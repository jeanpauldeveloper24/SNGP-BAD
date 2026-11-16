import 'package:flutter/material.dart';
import 'package:sngp_dashboard_1/screens/accueil_screen.dart';
import 'package:sngp_dashboard_1/screens/alertes_screen.dart';
import 'package:sngp_dashboard_1/screens/paiements_screen.dart';
import 'package:sngp_dashboard_1/screens/profile_screen.dart';
import 'package:sngp_dashboard_1/screens/rapports_screen.dart';

class Content extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onNavigateTab;

  const Content({
    super.key,
    required this.currentIndex,
    required this.onNavigateTab,
  });

  @override
  Widget build(BuildContext context) {
    // Définition des 4 sections de l'application prestataire
    final List<Widget> pages = [
      AccueilScreen(onNavigateTab: onNavigateTab), // 0: Home
      const RapportsScreen(),                        // Index 1 : Rapports
      const PaiementsScreen(),                       // Index 2 : Paiements
      const AlertesScreen(),
      const ProfileScreen(),
    ];

    return Padding(
      padding: const EdgeInsets.all(16.0),
      child: pages[currentIndex],
    );
  }
}