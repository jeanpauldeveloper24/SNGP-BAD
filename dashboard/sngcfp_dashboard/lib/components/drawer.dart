import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class AppDrawer extends StatelessWidget {
  final String userRole;
  final Function(String)? onMenuSelected;

  const AppDrawer({
    super.key,
    required this.userRole,
    this.onMenuSelected,
  });

  // 🎯 Menus par rôle
  List<Map<String, dynamic>> getMenuByRole() {
    switch (userRole) {
      case "ministere":
        return [
          {"icon": Icons.dashboard, "title": "Tableau de bord", "node": "dashboard"},
          {"icon": Icons.folder, "title": "Projets", "node": "projets"},
          {"icon": Icons.attach_money, "title": "Budgets", "node": "budgets"},
          {"icon": Icons.assignment, "title": "Rapports", "node": "rapports"},
        ];
      case "auditeur":
        return [
          {"icon": Icons.dashboard, "title": "Vue Générale", "node": "dashboard"},
          {"icon": Icons.search, "title": "Audit des comptes", "node": "audit"},
          {"icon": Icons.receipt_long, "title": "Pistes d’audit", "node": "pistes"},
          {"icon": Icons.warning, "title": "Alertes", "node": "alertes"},
        ];
      case "direction":
        return [
          {"icon": Icons.dashboard, "title": "Dashboard Exécutif", "node": "dashboard"},
          {"icon": Icons.analytics, "title": "Indicateurs", "node": "kpi"},
          {"icon": Icons.approval, "title": "Validations", "node": "validations"},
          {"icon": Icons.description, "title": "Rapports stratégiques", "node": "rapports"},
        ];
      case "bad":
      default:
        return [
          {"icon": Icons.dashboard, "title": "Vue BAD", "node": "dashboard"},
          {"icon": Icons.public, "title": "Suivi Projets", "node": "projets"},
          {"icon": Icons.account_balance, "title": "Financements", "node": "finances"},
          {"icon": Icons.bar_chart, "title": "Performance", "node": "kpi"},
        ];
    }
  }

  @override
  Widget build(BuildContext context) {
    final menuItems = getMenuByRole();

    return Drawer(
      backgroundColor: const Color(0xFF1B4F72),
      child: Column(
        children: [
          // 🔷 HEADER LOGO
          Container(
            height: 140,
            width: double.infinity,
            color: const Color(0xFF2E86C1),
            child: Center(
              child: Text(
                "LOGO",
                style: GoogleFonts.montserrat(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                  letterSpacing: 2,
                ),
              ),
            ),
          ),

          const SizedBox(height: 10),

          // 📋 MENUS
          Expanded(
            child: ListView.builder(
              itemCount: menuItems.length,
              itemBuilder: (context, index) {
                final item = menuItems[index];
                return ListTile(
                  leading: Icon(item["icon"], color: Colors.white),
                  title: Text(
                    item["title"],
                    style: GoogleFonts.inter(color: Colors.white),
                  ),
                  hoverColor: const Color(0xFF27AE60).withOpacity(0.2),
                  onTap: () {
                    if (onMenuSelected != null) {
                      onMenuSelected!(item["node"]);
                    }
                    Navigator.pop(context);
                  },
                );
              },
            ),
          ),

          // 🚪 LOGOUT
          ListTile(
            leading: const Icon(Icons.logout, color: Color(0xFFE74C3C)),
            title: Text(
              "Déconnexion",
              style: GoogleFonts.inter(
                color: const Color(0xFFE74C3C),
                fontWeight: FontWeight.bold,
              ),
            ),
            onTap: () {},
          ),

          const SizedBox(height: 20),
        ],
      ),
    );
  }
}