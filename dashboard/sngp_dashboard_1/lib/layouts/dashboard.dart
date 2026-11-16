import 'package:flutter/material.dart';
import 'package:sngp_dashboard_1/layouts/guest.dart';
import 'package:sngp_dashboard_1/layouts/content.dart';
import 'package:sngp_dashboard_1/layouts/navigation.dart';
import 'package:sngp_dashboard_1/screens/profile_screen.dart';

class Dashboard extends StatefulWidget {
  const Dashboard({super.key});

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  // Index global pour suivre l'onglet actif
  int _currentIndex = 0;

  void _handleTabChanged(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6), // Gris Perle Très Clair
      body: SafeArea(
        child: Column(
          children: [
            // 1. lib/layouts/guest.dart (En haut : Logo, Nom du prestataire, Profil)
            Guest(
              prestataireName: 'Entreprise BTP Poro SARL',
              onProfilePressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const ProfileScreen(),
                  ),
                );
              },
            ),

            // 2. lib/layouts/content.dart (Au milieu : Affiche dynamiquement le contenu de la page active)
            Expanded(
              child: Content(
                currentIndex: _currentIndex,
                onNavigateTab: _handleTabChanged,
              ),
            ),
          ],
        ),
      ),

      // 3. lib/layouts/navigation.dart (En bas : Barre de navigation épurée)
      bottomNavigationBar: NavigationWidget(
        currentIndex: _currentIndex,
        onTabChanged: _handleTabChanged,
      ),
    );
  }
}
