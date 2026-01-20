import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:syncfusion_flutter_charts/charts.dart';

class HomeScreen extends StatelessWidget {
  final String userName = "M. LE MINISTRE"; // À récupérer via votre logique Auth

  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    // Couleurs de la charte graphique
    const Color primaryBlue = Color(0xFF1B4F72);
    const Color secondaryBlue = Color(0xFF2E86C1);
    const Color backgroundGray = Color(0xFFF4F7F6);
    const Color successGreen = Color(0xFF27AE60);

    return Scaffold(
      backgroundColor: backgroundGray,
      body: Column(
        children: [
          // --- I. HEADER INSTITUTIONNEL ---
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 20),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.05),
                  blurRadius: 10,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                // Logo BAD
                Image.asset('images/logo_bad.png', height: 80),

                // Message de Bienvenue
                Column(
                  children: [
                    Text(
                      "BIENVENU",
                      style: GoogleFonts.montserrat(
                        fontSize: 16,
                        letterSpacing: 2,
                        color: secondaryBlue,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    Text(
                      userName.toUpperCase(),
                      style: GoogleFonts.montserrat(
                        fontSize: 28,
                        fontWeight: FontWeight.bold,
                        color: primaryBlue,
                      ),
                    ),
                    Container(
  margin: const EdgeInsets.only(top: 5),
  height: 3,
  width: 60,
  color: const Color(0xFFE74C3C),
)
                  ],
                ),

                // Armoiries Côte d'Ivoire
                Image.asset('images/armoiries_ci.png', height: 80),
              ],
            ),
          ),

          // --- II. CORPS DE PAGE ---
          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(40),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    "Données des projets",
                    style: GoogleFonts.montserrat(
                      fontSize: 22,
                      fontWeight: FontWeight.bold,
                      color: primaryBlue,
                    ),
                  ),
                  const SizedBox(height: 25),

                  // --- GRILLE DES KPI RAPIDES ---
                  Row(
                    children: [
                      _buildKpiCard("Projets Actifs", "24", Icons.folder_special, secondaryBlue),
                      _buildKpiCard("Budget Global", "45.8 Md FCFA", Icons.account_balance_wallet, primaryBlue),
                      _buildKpiCard("Taux Décaissement", "62%", Icons.trending_up, successGreen),
                    ],
                  ),

                  const SizedBox(height: 40),

                  // --- SECTION GRAPHIQUE ET LISTE ---
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Graphique d'exécution (Syncfusion)
                      Expanded(
                        flex: 2,
                        child: _buildChartSection(primaryBlue),
                      ),
                      const SizedBox(width: 30),
                      // Liste des derniers projets
                      Expanded(
                        flex: 1,
                        child: _buildRecentProjects(primaryBlue),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  // Widget : Carte KPI
  Widget _buildKpiCard(String title, String value, IconData icon, Color color) {
    return Expanded(
      child: Container(
        margin: const EdgeInsets.only(right: 20),
        padding: const EdgeInsets.all(25),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: Colors.grey.withOpacity(0.1)),
        ),
        child: Row(
          children: [
            CircleAvatar(
              backgroundColor: color.withOpacity(0.1),
              child: Icon(icon, color: color),
            ),
            const SizedBox(width: 20),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: GoogleFonts.inter(color: Colors.grey[600], fontSize: 14)),
                Text(value, style: GoogleFonts.montserrat(fontSize: 20, fontWeight: FontWeight.bold)),
              ],
            )
          ],
        ),
      ),
    );
  }

  // Widget : Section Graphique
  Widget _buildChartSection(Color color) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Évolution des Décaissements", style: GoogleFonts.montserrat(fontWeight: FontWeight.bold)),
          const SizedBox(height: 20),
          SizedBox(
            height: 300,
            child: SfCartesianChart(
              primaryXAxis: CategoryAxis(),
              series: <CartesianSeries>[
                ColumnSeries<dynamic, String>(
                  dataSource: [
                    {'m': 'Jan', 'v': 12},
                    {'m': 'Fév', 'v': 18},
                    {'m': 'Mar', 'v': 25},
                    {'m': 'Avr', 'v': 22},
                  ],
                  xValueMapper: (data, _) => data['m'],
                  yValueMapper: (data, _) => data['v'],
                  color: color,
                  borderRadius: const BorderRadius.vertical(top: Radius.circular(5)),
                )
              ],
            ),
          ),
        ],
      ),
    );
  }

  // Widget : Liste des Projets
  Widget _buildRecentProjects(Color color) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Statuts Récents", style: GoogleFonts.montserrat(fontWeight: FontWeight.bold)),
          const SizedBox(height: 20),
          _projectTile("Amélioration Électricité", "85%", Colors.green),
          _projectTile("Réseau Routier Est", "42%", Colors.orange),
          _projectTile("Projet Eau Abidjan", "12%", Colors.blue),
        ],
      ),
    );
  }

  Widget _projectTile(String name, String progress, Color statusColor) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(name, style: GoogleFonts.inter(fontSize: 13, fontWeight: FontWeight.w500)),
              Text(progress, style: GoogleFonts.inter(fontSize: 12, color: statusColor, fontWeight: FontWeight.bold)),
            ],
          ),
          const SizedBox(height: 5),
          LinearProgressIndicator(
            value: double.parse(progress.replaceAll('%', '')) / 100,
            backgroundColor: Colors.grey[200],
            color: statusColor,
            minHeight: 6,
          ),
        ],
      ),
    );
  }
}