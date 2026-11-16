import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class AlertesScreen extends StatefulWidget {
  const AlertesScreen({super.key});

  @override
  State<AlertesScreen> createState() => _AlertesScreenState();
}

class _AlertesScreenState extends State<AlertesScreen> {
  static const Color primaryColor = Color(0xFF1B4F72);
  static const Color secondaryColor = Color(0xFF2E86C1);
  static const Color alertColor = Color(0xFFE74C3C);
  static const Color accentColor = Color(0xFF27AE60);
  static const Color textDark = Color(0xFF2C3E50);
  static const Color bgLight = Color(0xFFF4F7F6);

  final _formKey = GlobalKey<FormState>();
  final _titleController = TextEditingController();
  final _texteController = TextEditingController();

  String _selectedType = 'anomalie';
  String _selectedNiveau = 'moyen';
  bool _isLoading = false;

  // Variables pour la gestion de l'image (Base64 pour la migration Laravel)
  File? _imageFile;
  String? _base64Image;

  final List<String> _typesList = ['anomalie', 'technique', 'meteo', 'securite', 'autre'];
  final List<String> _niveauxList = ['faible', 'moyen', 'eleve', 'extreme'];

  // Méthode pour capturer ou sélectionner une image
  Future<void> _pickImage(ImageSource source) async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(source: source, imageQuality: 70);

    if (pickedFile != null) {
      final bytes = await File(pickedFile.path).readAsBytes();
      setState(() {
        _imageFile = File(pickedFile.path);
        _base64Image = base64Encode(bytes); // Conversion directe en Base64
      });
    }
  }

  void _sendAlerte() async {
    if (_formKey.currentState!.validate()) {
      setState(() => _isLoading = true);

      // Données prêtes à être envoyées à votre API Laravel (POST /api/alertes) :
      // - type: _selectedType
      // - niveau: _selectedNiveau
      // - title: _titleController.text
      // - texte: _texteController.text
      // - media: _base64Image (stocké dans le longText de la base de données)

      await Future.delayed(const Duration(seconds: 2)); // Simulation API

      setState(() => _isLoading = false);

      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Alerte et média transmis avec succès au système SNGP-BAD !'),
          backgroundColor: accentColor,
        ),
      );

      // Réinitialisation du formulaire
      _titleController.clear();
      _texteController.clear();
      setState(() {
        _selectedType = 'anomalie';
        _selectedNiveau = 'moyen';
        _imageFile = null;
        _base64Image = null;
      });
    }
  }

  @override
  void dispose() {
    _titleController.dispose();
    _texteController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Material(
      color: bgLight,
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Centre d\'Alertes & SOS',
              style: TextStyle(fontFamily: 'Montserrat', fontSize: 18, fontWeight: FontWeight.bold, color: alertColor),
            ),
            const SizedBox(height: 4),
            const Text(
              'Signalez un incident critique avec photo justificative.',
              style: TextStyle(fontFamily: 'Inter', fontSize: 13, color: textDark),
            ),
            const SizedBox(height: 16),

            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: alertColor.withOpacity(0.3)),
                boxShadow: [
                  BoxShadow(color: textDark.withOpacity(0.04), blurRadius: 10, offset: const Offset(0, 4)),
                ],
              ),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Type d'alerte
                    const Text('Type d\'alerte', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    DropdownButtonFormField<String>(
                      value: _selectedType,
                      decoration: InputDecoration(
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                        contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                      ),
                      items: _typesList
                          .map((t) => DropdownMenuItem(value: t, child: Text(t.toUpperCase(), style: const TextStyle(fontFamily: 'Inter'))))
                          .toList(),
                      onChanged: (val) => setState(() => _selectedType = val!),
                    ),
                    const SizedBox(height: 16),

                    // Niveau d'urgence
                    const Text('Niveau d\'urgence', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    DropdownButtonFormField<String>(
                      value: _selectedNiveau,
                      decoration: InputDecoration(
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                        contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                      ),
                      items: _niveauxList
                          .map((n) => DropdownMenuItem(value: n, child: Text(n.toUpperCase(), style: const TextStyle(fontFamily: 'Inter'))))
                          .toList(),
                      onChanged: (val) => setState(() => _selectedNiveau = val!),
                    ),
                    const SizedBox(height: 16),

                    // Objet / Titre
                    const Text('Objet de l\'urgence (Titre)', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    TextFormField(
                      controller: _titleController,
                      decoration: InputDecoration(
                        hintText: 'Ex: Panne critique du groupe électrogène',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                      ),
                      validator: (val) => val == null || val.trim().isEmpty ? 'Veuillez saisir un objet' : null,
                    ),
                    const SizedBox(height: 16),

                    // Description détaillée
                    const Text('Description détaillée (Texte)', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    TextFormField(
                      controller: _texteController,
                      maxLines: 4,
                      decoration: InputDecoration(
                        hintText: 'Expliquez la situation en détail...',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                      ),
                      validator: (val) => val == null || val.trim().isEmpty ? 'Veuillez décrire le problème' : null,
                    ),
                    const SizedBox(height: 16),

                    // SECTION PHOTO / MÉDIA
                    const Text('Photo justificative du problème (Optionnel)', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    Row(
                      children: [
                        Expanded(
                          child: OutlinedButton.icon(
                            style: OutlinedButton.styleFrom(
                              padding: const EdgeInsets.symmetric(vertical: 12),
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                              side: BorderSide(color: secondaryColor),
                            ),
                            onPressed: () => _pickImage(ImageSource.camera),
                            icon: const Icon(Icons.camera_alt, color: secondaryColor),
                            label: const Text('Caméra', style: TextStyle(fontFamily: 'Montserrat', color: secondaryColor)),
                          ),
                        ),
                        const SizedBox(width: 12),
                        Expanded(
                          child: OutlinedButton.icon(
                            style: OutlinedButton.styleFrom(
                              padding: const EdgeInsets.symmetric(vertical: 12),
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                              side: BorderSide(color: secondaryColor),
                            ),
                            onPressed: () => _pickImage(ImageSource.gallery),
                            icon: const Icon(Icons.photo_library, color: secondaryColor),
                            label: const Text('Galerie', style: TextStyle(fontFamily: 'Montserrat', color: secondaryColor)),
                          ),
                        ),
                      ],
                    ),

                    // Aperçu de l'image sélectionnée
                    if (_imageFile != null) ...[
                      const SizedBox(height: 12),
                      Stack(
                        alignment: Alignment.topRight,
                        children: [
                          ClipRRect(
                            borderRadius: BorderRadius.circular(8),
                            child: Image.file(
                              _imageFile!,
                              height: 160,
                              width: double.infinity,
                              fit: BoxFit.cover,
                            ),
                          ),
                          IconButton(
                            icon: const Icon(Icons.remove_circle, color: alertColor, size: 28),
                            onPressed: () => setState(() {
                              _imageFile = null;
                              _base64Image = null;
                            }),
                          ),
                        ],
                      ),
                    ],
                    const SizedBox(height: 24),

                    // Bouton d'envoi
                    SizedBox(
                      width: double.infinity,
                      height: 45,
                      child: ElevatedButton(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: alertColor,
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                        ),
                        onPressed: _isLoading ? null : _sendAlerte,
                        child: _isLoading
                            ? const SizedBox(
                                height: 20,
                                width: 20,
                                child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                              )
                            : const Text('Diffuser l\'Alerte SOS', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold)),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}