import 'package:flutter/material.dart';

class NavigationWidget extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onTabChanged;

  const NavigationWidget({
    super.key,
    required this.currentIndex,
    required this.onTabChanged,
  });

  static const Color primaryColor = Color(0xFF1B4F72); // Bleu Cobalt Profond

  @override
  Widget build(BuildContext context) {
    return BottomNavigationBar(
      currentIndex: currentIndex,
      onTap: onTabChanged,
      type: BottomNavigationBarType.fixed,
      backgroundColor: Colors.white,
      selectedItemColor: primaryColor,
      unselectedItemColor: const Color(0xFF9CA3AF),
      showSelectedLabels: false,
      showUnselectedLabels: false,
      elevation: 8,
      items: const [
        BottomNavigationBarItem(
          icon: Icon(Icons.home_outlined, size: 26),
          activeIcon: Icon(Icons.home, size: 26),
          label: 'Home',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.assignment_outlined, size: 26),
          activeIcon: Icon(Icons.assignment, size: 26),
          label: 'Rapports',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.payments_outlined, size: 26),
          activeIcon: Icon(Icons.payments, size: 26),
          label: 'Paiements',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.warning_amber_rounded, size: 26),
          activeIcon: Icon(Icons.warning, size: 26),
          label: 'Alertes',
        ),
      ],
    );
  }
}