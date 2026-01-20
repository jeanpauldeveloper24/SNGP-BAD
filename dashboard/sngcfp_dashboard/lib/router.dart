import 'package:flutter/material.dart';
import 'package:sngcfp_dashboard/dashboard.dart';
import 'package:sngcfp_dashboard/login.dart';
import 'package:sngcfp_dashboard/model/user_role.dart';
import 'package:sngcfp_dashboard/register.dart';

class AppKeys {
  // Routes principales
  static const String login = '/login';
  static const String register = '/register';
  static const String dashboard = '/dashboard';

  // Sous-pages du dashboard
  static const String accueil = '/accueil';
  static const String projetsListe = '/projets/liste';
  static const String projetsAvancement = '/projets/avancement';
  static const String projetsRapports = '/projets/rapports';

  static const String budgetsGraphiques = '/budgets/graphique';
  static const String budgetsAlertes = '/budgets/alertes';

  static const String marchesCours = '/marches/cours';
  static const String appelsOffres = '/marches/appels';
  static const String engagementsPaiements = '/marches/engagements';

  static const String rapports = '/rapports';
  static const String alertes = '/alertes';
  static const String kpi = '/kpi';
  static const String audit = '/audit';
  static const String parametres = '/parametres';

  // Node générique pour le drawer
  static const String nodeAccueil = 'accueil';
}

// Map pour associer les nœuds aux noms d'affichage dans le Drawer
const Map<String, String> nodeDisplayNames = {
  AppKeys.nodeAccueil: 'Accueil',
  AppKeys.projetsListe: 'Liste des projets',
  AppKeys.projetsAvancement: 'Avancement des projets',
  AppKeys.projetsRapports: 'Rapports PDF/Excel',
  AppKeys.budgetsGraphiques: 'Graphiques budgétaires',
  AppKeys.budgetsAlertes: 'Alertes budgétaires',
  AppKeys.marchesCours: 'Marchés en cours',
  AppKeys.appelsOffres: 'Appels d’offres',
  AppKeys.engagementsPaiements: 'Engagements & Paiements',
  AppKeys.rapports: 'Rapports & Documents',
  AppKeys.alertes: 'Alertes & Notifications',
  AppKeys.kpi: 'Analyse & KPI',
  AppKeys.audit: 'Audit & Historique',
  AppKeys.parametres: 'Paramètres / Préférences',
};

// Map de routage pour Navigator
Map<String, WidgetBuilder> appRoutes = {
  AppKeys.login: (context) => Login(),
  AppKeys.register: (context) => Register(),
  AppKeys.dashboard: (context) => Dashboard(role: UserRole.admin,),

  // Sous-pages du dashboard
  /*AppKeys.projetsListe: (context) => ProjetsListe(),
  AppKeys.projetsAvancement: (context) => ProjetsAvancement(),
  AppKeys.projetsRapports: (context) => ProjetsRapports(),

  AppKeys.budgetsGraphiques: (context) => BudgetsGraphiques(),
  AppKeys.budgetsAlertes: (context) => BudgetsAlertes(),

  AppKeys.marchesCours: (context) => MarchesCours(),
  AppKeys.appelsOffres: (context) => AppelsOffres(),
  AppKeys.engagementsPaiements: (context) => EngagementsPaiements(),

  AppKeys.rapports: (context) => Rapports(),
  AppKeys.alertes: (context) => Alertes(),
  AppKeys.kpi: (context) => KPI(),
  AppKeys.audit: (context) => Audit(),
  AppKeys.parametres: (context) => Parametres(),*/
};