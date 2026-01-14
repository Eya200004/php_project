import { DashboardLayout } from '@/components/DashboardLayout';
import { ProtectedRoute } from '@/components/ProtectedRoute';
import { Card } from '@/components/ui/card';

export default function StudentDocuments() {
  return (
    <ProtectedRoute allowedRoles={['etudiant']}>
      <DashboardLayout
        title="Course Documents"
        description="Access course materials and resources"
      >
        <Card className="p-8 text-center">
          <p className="text-muted-foreground">Document access features coming soon</p>
        </Card>
      </DashboardLayout>
    </ProtectedRoute>
  );
}
