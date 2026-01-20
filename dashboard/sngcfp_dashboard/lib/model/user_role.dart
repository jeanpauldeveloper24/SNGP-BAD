enum UserRole {
  ministere,
  auditeur,
  direction,
  bad,
  admin
}

extension UserRoleExtension on UserRole {
  String get label {
    switch (this) {
      case UserRole.ministere:
        return "Ministère";
      case UserRole.auditeur:
        return "Auditeur";
      case UserRole.direction:
        return "Direction";
      case UserRole.bad:
        return "BAD";
      case UserRole.admin:
        return "Administrateur";
    }
  }
}