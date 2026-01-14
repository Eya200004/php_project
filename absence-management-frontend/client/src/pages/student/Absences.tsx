import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function StudentAbsences() {
  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="My Absences"
        description="View your justified, unjustified, and total absences"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Absence tracking features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
