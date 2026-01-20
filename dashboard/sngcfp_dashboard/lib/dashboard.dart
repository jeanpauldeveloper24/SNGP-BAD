import 'package:flutter/material.dart';
import 'package:sngcfp_dashboard/components/content.dart';
import 'package:sngcfp_dashboard/model/user_role.dart';
import 'package:sngcfp_dashboard/components/drawer.dart';

class Dashboard extends StatefulWidget {
  final UserRole role;
  const Dashboard({super.key, required this.role,});

  @override
  State<Dashboard> createState() => _DashboardState();
}

class _DashboardState extends State<Dashboard> {
  String currentNode = "dashboard";

  void onMenuSelected(String node) {
    setState(() {
      currentNode = node;
    });
    Navigator.pop(context); // ferme le drawer
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      drawer: AppDrawer(
  userRole: widget.role.name.toLowerCase(),
  onMenuSelected: onMenuSelected,
),
      appBar: AppBar(
        title: const Text("SNSDAS - BAD Côte d'Ivoire"),
        backgroundColor: const Color(0xFF1B4F72),
      ),
      body: DashboardContent(currentNode: currentNode),
    );
  }
}
