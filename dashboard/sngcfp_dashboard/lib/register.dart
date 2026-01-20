import 'dart:io';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:image_picker/image_picker.dart';
import 'package:sngcfp_dashboard/model/user_role.dart';
import 'package:sngcfp_dashboard/login.dart';

class Register extends StatefulWidget {
  const Register({super.key});

  @override
  State<Register> createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  UserRole? _selectedRole;

  File? selectedImage; // Image réelle

  final List<UserRole> roles = [
    UserRole.bad,
    UserRole.ministere,
    UserRole.direction,
    UserRole.auditeur,
    UserRole.admin,
  ];

  // Fonction pour choisir l'image
  Future<void> pickImage() async {
    final picker = ImagePicker();
    final XFile? image = await picker.pickImage(source: ImageSource.gallery);

    if (image != null) {
      setState(() {
        selectedImage = File(image.path);
      });
    }
  }

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
                  // Header logos + titre
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Image.asset("images/armoirie_ci.png", height: 50),
                      const SizedBox(width: 10),
                      Text(
                        "Inscription",
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

                  // Champ Nom complet
                  TextFormField(
                    controller: _nameController,
                    decoration: InputDecoration(
                      labelText: "Nom complet",
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

                  // Champ Email
                  TextFormField(
                    controller: _emailController,
                    decoration: InputDecoration(
                      labelText: "Email",
                      prefixIcon: const Icon(Icons.email),
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
                    controller: _passwordController,
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

                  const SizedBox(height: 20),

                  // Dropdown pour le rôle
                  DropdownButtonFormField<UserRole>(
                    value: _selectedRole,
                    decoration: InputDecoration(
                      labelText: "Rôle",
                      prefixIcon: const Icon(Icons.admin_panel_settings),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                      filled: true,
                      fillColor: grisPerle,
                      focusedBorder: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide(color: bleuCobalt, width: 2),
                      ),
                    ),
                    items: roles
                        .map((role) => DropdownMenuItem(
                              value: role,
                              child: Text(role.name),
                            ))
                        .toList(),
                    onChanged: (v) => setState(() => _selectedRole = v),
                    validator: (v) => v == null ? "Sélectionnez un rôle" : null,
                  ),

                  const SizedBox(height: 20),

                  // Sélection d'image
                  GestureDetector(
                    onTap: pickImage,
                    child: Container(
                      height: 120,
                      decoration: BoxDecoration(
                        border: Border.all(color: bleuCobalt),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Center(
                        child: Text(
                          selectedImage == null
                              ? "📸 Sélectionner photo"
                              : "✅ Photo sélectionnée",
                          style: GoogleFonts.inter(fontSize: 16),
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 30),

                  // Bouton Créer le compte
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: bleuCobalt,
                        padding: const EdgeInsets.symmetric(vertical: 18),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                        elevation: 5,
                      ),
                      onPressed: () {
                        if (_formKey.currentState!.validate() && selectedImage != null) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text("Compte prêt pour Firebase 🚀")),
                          );
                          // TODO: Ajouter la logique Firebase ici
                        } else if (selectedImage == null) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text("Veuillez sélectionner une photo")),
                          );
                        }
                      },
                      child: const Text(
                        "Créer le compte",
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 20),

                  // Texte secondaire "Vous avez déjà un compte ? Connectez-vous"
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        "Vous avez déjà un compte ? ",
                        style: GoogleFonts.inter(fontSize: 14),
                      ),
                      GestureDetector(
                        onTap: () {
                          Navigator.pushReplacement(
                            context,
                            MaterialPageRoute(builder: (_) => const Login()),
                          );
                        },
                        child: Text(
                          "Connectez-vous",
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