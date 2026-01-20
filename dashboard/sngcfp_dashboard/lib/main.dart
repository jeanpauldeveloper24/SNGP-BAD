import 'package:flutter/material.dart';
import 'package:sngcfp_dashboard/register.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});


  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SNGCFP Dashboard',
      home: const Register(),
    );
  }
}
