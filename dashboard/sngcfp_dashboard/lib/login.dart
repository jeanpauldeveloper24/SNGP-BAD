import 'package:flutter/material.dart'; 
import 'package:google_fonts/google_fonts.dart';
import 'package:sngcfp_dashboard/dashboard.dart';
import 'package:sngcfp_dashboard/model/user_role.dart';
import 'package:sngcfp_dashboard/register.dart';

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _identifier = TextEditingController();
  final TextEditingController _password = TextEditingController();

  final List<Map<String, dynamic>> users = [
    {"id": "bad@afdb.org", "password": "123456", "role": UserRole.bad},
    {"id": "ministere@gouv.ci", "password": "123456", "role": UserRole.ministere},
    {"id": "direction@gouv.ci", "password": "123456", "role": UserRole.direction},
    {"id": "audit@control.ci", "password": "123456", "role": UserRole.auditeur},
    {"id": "admin@system.ci", "password": "admin123", "role": UserRole.admin},
  ];

  @override
  Widget build(BuildContext context) {
    const Color bleuCobalt = Color(0xFF1B4F72);
    const Color bleuArdoise = Color(0xFF2E86C1);
    const Color vertEmer = Color(0xFF27AE60);
    const Color grisPerle = Color(0xFFF4F7F6);

    return Scaffold(
      body: Container(
        width: double.infinity,
        height: double.infinity,
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [bleuCobalt, bleuArdoise],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: Container(
              constraints: const BoxConstraints(maxWidth: 450),
              padding: const EdgeInsets.all(30),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.15),
                    blurRadius: 25,
                    offset: const Offset(0, 15),
                  )
                ],
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  // Header avec logos et texte centré
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Image.asset("images/armoirie_ci.png", height: 50),
                      const SizedBox(width: 10),
                      Text(
                        "Connectez-vous",
                        style: GoogleFonts.montserrat(
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                          color: bleuCobalt,
                        ),
                      ),
                      const SizedBox(width: 10),
                      Image.asset("images/logo_bad.png", height: 50),
                    ],
                  ),

                  const SizedBox(height: 35),

                  // Champ Nom ou Email
                  TextFormField(
                    controller: _identifier,
                    decoration: InputDecoration(
                      labelText: "Nom ou Email",
                      prefixIcon: const Icon(Icons.person),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                      filled: true,
                      fillColor: grisPerle,
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: bleuCobalt, width: 2),
                      ),
                    ),
                    style: GoogleFonts.inter(),
                    validator: (v) => v!.isEmpty ? "Champ requis" : null,
                  ),

                  const SizedBox(height: 20),

                  // Champ Mot de passe
                  TextFormField(
                    controller: _password,
                    obscureText: true,
                    decoration: InputDecoration(
                      labelText: "Mot de passe",
                      prefixIcon: const Icon(Icons.lock),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                      filled: true,
                      fillColor: grisPerle,
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: bleuCobalt, width: 2),
                      ),
                    ),
                    style: GoogleFonts.inter(),
                    validator: (v) => v!.length < 6 ? "6 caractères min." : null,
                  ),

                  const SizedBox(height: 30),

                  // Bouton Se connecter
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: bleuCobalt,
                        padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 15),
                      ),
                      onPressed: () {
                        if (_formKey.currentState!.validate()) {
                          final user = users.where((u) =>
                            u["id"] == _identifier.text.trim() &&
                            u["password"] == _password.text.trim()
                          );

                          if (user.isNotEmpty) {
                            Navigator.pushReplacement(
                              context,
                              MaterialPageRoute(
                                builder: (_) => Dashboard(role: user.first["role"]),
                              ),
                            );
                          } else {
                            ScaffoldMessenger.of(context).showSnackBar(
                              const SnackBar(content: Text("Identifiants incorrects")),
                            );
                          }
                        }
                      },
                      child: const Text(
                        "Se connecter",
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 20),

                  // Texte secondaire "Vous n'avez pas de compte ? inscrivez-vous"
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        "Vous n'avez pas de compte ? ",
                        style: GoogleFonts.inter(fontSize: 14),
                      ),
                      GestureDetector(
                        onTap: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(builder: (_) => const Register()),
                          );
                        },
                        child: Text(
                          "inscrivez-vous",
                          style: GoogleFonts.montserrat(
                            fontWeight: FontWeight.bold,
                            fontSize: 14,
                            color: vertEmer,
                          ),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}