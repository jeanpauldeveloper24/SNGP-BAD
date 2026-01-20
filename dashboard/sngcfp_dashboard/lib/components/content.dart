import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class DashboardContent extends StatelessWidget {
  final String currentNode;

  const DashboardContent({super.key, required this.currentNode});

  @override
  Widget build(BuildContext context) {
    TextStyle title = GoogleFonts.montserrat(
      fontSize: 22,
      fontWeight: FontWeight.bold,
      color: const Color(0xFF1B4F72),
    );

    Widget content;

    switch (currentNode) {
      case "projets":
        content = const Text("📁 Module Projets");
        break;
      case "budgets":
        content = const Text("💰 Module Budgets & Finances");
        break;
      case "marches":
        content = const Text("⚖️ Module Passation de Marchés");
        break;
      case "rapports":
        content = const Text("📄 Module Rapports & Documents");
        break;
      case "kpi":
        content = const Text("📊 Module Analyse & KPI");
        break;
      case "audit":
        content = const Text("🕵️ Module Audit & Historique");
        break;
      case "parametres":
        content = const Text("⚙️ Module Paramètres");
        break;
      default:
        content = const Text("🏠 Tableau de Bord Principal");
    }

    return Padding(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Dashboard", style: title),
          const SizedBox(height: 20),
          Card(
            elevation: 2,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
            child: Padding(
              padding: const EdgeInsets.all(20),
              child: content,
            ),
          ),
        ],
      ),
    );
  }
}