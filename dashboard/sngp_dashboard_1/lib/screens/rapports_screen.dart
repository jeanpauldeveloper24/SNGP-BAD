import 'package:flutter/material.dart';

class RapportsScreen extends StatefulWidget {
  const RapportsScreen({super.key});

  @override
  State<RapportsScreen> createState() => _RapportsScreenState();
}

class _RapportsScreenState extends State<RapportsScreen> {
  static const Color primaryColor = Color(0xFF1B4F72);
  static const Color secondaryColor = Color(0xFF2E86C1);
  static const Color accentColor = Color(0xFF27AE60);
  static const Color textDark = Color(0xFF2C3E50);
  static const Color bgLight = Color(0xFFF4F7F6);

  final _formKey = GlobalKey<FormState>();
  final _effectifController = TextEditingController();
  final _travauxController = TextEditingController();
  String _meteoSelection = 'Ensoleillé';

  void _submitRapport() {
    if (_formKey.currentState!.validate()) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Rapport quotidien enregistré avec succès !')),
      );
      _effectifController.clear();
      _travauxController.clear();
    }
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
              'Journal de Chantier',
              style: TextStyle(fontFamily: 'Montserrat', fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor),
            ),
            const SizedBox(height: 4),
            const Text(
              'Renseignez l\'activité quotidienne sur le site.',
              style: TextStyle(fontFamily: 'Inter', fontSize: 13, color: textDark),
            ),
            const SizedBox(height: 16),

            // Formulaire de saisie rapide
            Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: secondaryColor.withOpacity(0.2)),
                boxShadow: [
                  BoxShadow(color: textDark.withOpacity(0.04), blurRadius: 10, offset: const Offset(0, 4)),
                ],
              ),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text('Météo du site', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    DropdownButtonFormField<String>(
                      value: _meteoSelection,
                      decoration: InputDecoration(
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                        contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                      ),
                      items: ['Ensoleillé', 'Pluvieux', 'Venteux', 'Orageux']
                          .map((m) => DropdownMenuItem(value: m, child: Text(m, style: const TextStyle(fontFamily: 'Inter'))))
                          .toList(),
                      onChanged: (val) => setState(() => _meteoSelection = val!),
                    ),
                    const SizedBox(height: 16),

                    const Text('Effectif ouvrier présent', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    TextFormField(
                      controller: _effectifController,
                      keyboardType: TextInputType.number,
                      decoration: InputDecoration(
                        hintText: 'Ex: 15 ouvriers',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                      ),
                      validator: (val) => val == null || val.isEmpty ? 'Champ requis' : null,
                    ),
                    const SizedBox(height: 16),

                    const Text('Travaux réalisés aujourd\'hui', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold, fontSize: 13, color: textDark)),
                    const SizedBox(height: 8),
                    TextFormField(
                      controller: _travauxController,
                      maxLines: 3,
                      decoration: InputDecoration(
                        hintText: 'Décrivez les tâches exécutées...',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        filled: true,
                        fillColor: bgLight,
                      ),
                      validator: (val) => val == null || val.isEmpty ? 'Champ requis' : null,
                    ),
                    const SizedBox(height: 20),

                    SizedBox(
                      width: double.infinity,
                      height: 45,
                      child: ElevatedButton(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: accentColor,
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                        ),
                        onPressed: _submitRapport,
                        child: const Text('Soumettre le rapport', style: TextStyle(fontFamily: 'Montserrat', fontWeight: FontWeight.bold)),
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