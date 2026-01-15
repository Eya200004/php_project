export default function ScanPresence() {
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">
        Scanner la présence
      </h1>

      <p className="text-gray-600 mb-6">
        Scannez le QR code affiché par votre enseignant pour marquer votre présence.
      </p>

      <div className="border-2 border-dashed rounded-lg p-10 text-center text-gray-400">
        📷 Zone de scan QR
      </div>
    </div>
  );
}
