import 'package:flutter/material.dart';
import 'package:sngp_dashboard_1/auth/login_screen.dart';
import 'package:sngp_dashboard_1/layouts/dashboard.dart';
import 'package:sngp_dashboard_1/screens/accueil_screen.dart';
import 'package:sngp_dashboard_1/screens/alertes_screen.dart';
import 'package:sngp_dashboard_1/screens/paiements_screen.dart';
import 'package:sngp_dashboard_1/screens/profile_screen.dart';
import 'package:sngp_dashboard_1/screens/rapports_screen.dart';


class AppRoutes {
  static const String login = '/login';
  static const String dashboard = '/dashboard';
  static const String home = '/home';
  static const String rapports = '/rapports';
  static const String paiements = '/paiements';
  static const String alertes = '/alertes';
  static const String profile = '/profile';

  static Map<String, WidgetBuilder> getRoutes() {
    return {
      login: (context) => const LoginScreen(),
      dashboard: (context) => const Dashboard(),
      home: (context) => const AccueilScreen(),
      rapports: (context) => const RapportsScreen(),
      paiements: (context) => const PaiementsScreen(),
      alertes: (context) => const AlertesScreen(),
      profile: (context) => const ProfileScreen(),
    };
  }
}