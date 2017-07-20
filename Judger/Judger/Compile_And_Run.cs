using System;
using System.IO;
using System.Threading;
using System.Diagnostics;
namespace Judger {
	public class Compile_and_Run {
		private string SourceFile, DestinationFile;
		Process Run, Compile;
		public string Error = "", Output = "", ExitCode = "";

		public void copy_participant_code(string s, string extend) {
			SourceFile = s;
			DestinationFile = GlobalConstant.destination + "a" + extend;
			try {
				File.Copy (SourceFile, DestinationFile);	
			} catch (Exception ex) {
				Console.WriteLine ("Error copying participant's code: {0}", ex.Message);
			}
			try {
				File.Delete (SourceFile); // delete processed code
			} catch (Exception ex) {
				Console.WriteLine ("Error deleting participant's code: {0}", ex.Message);
			}
		}

		public void Compile_with (string Compiler, string extend) {
			Compile = new Process ();
			Compile.StartInfo.FileName = Compiler;
			Compile.StartInfo.Arguments = GlobalConstant.destination + "a" + extend;
			Compile.StartInfo.WorkingDirectory = GlobalConstant.destination;
			try {
				Compile.Start ();
				Compile.WaitForExit ();
			}
			catch (Exception ex) {
				Console.WriteLine ("Compile error {0}", ex.Message);
			}
			Compile.Close ();
			Compile.Dispose ();
			try {
				File.Delete (GlobalConstant.destination + "a" + extend);
			}
			catch (Exception ex) {
				Console.WriteLine ("Error deleting participant's code: {0}", ex.Message);
			}
		}

		public int Run_participant_code_with (string test_address_input, string Compiled_program_extend) {			
			Run = new Process ();
			Run.StartInfo.FileName = GlobalConstant.destination + "a" + Compiled_program_extend;
			Run.StartInfo.WorkingDirectory = GlobalConstant.destination;
			Run.StartInfo.UseShellExecute = false;
			Run.StartInfo.RedirectStandardInput = true;
			Run.StartInfo.RedirectStandardError = true;
			Run.StartInfo.RedirectStandardOutput = true;
			Run.StartInfo.CreateNoWindow = true;
			try {				

				Run.Start ();																				

				bool exited = Run.WaitForExit (Convert.ToInt32(GlobalConstant.TimeLimit * 1000.0));								

				if (!exited) {						

					GlobalConstant.TLE = true;
					try {
						Run.Kill();
						Run.Close ();
						Run.Dispose (); 
						//Console.WriteLine ("Has Stopped: {0}", Run.Responding );
					}
					catch (Exception ex) {
						Console.WriteLine ("Problem killing: {0}", ex.Message);
					}

				}


				/* Input to the program */
				//StreamReader read_output = Run.StandardOutput;
				/* Get the output */
				//StreamReader read_error = Run.StandardError;
				/* Get the errors */				

				//Output = read_output.ReadToEnd (); // Program's OUTPUT
				//Error = read_error.ReadToEnd (); // Program's ERROR
				//ExitCode = Run.ExitCode.ToString (); // Program's ExitCode
				StreamReader participant_output = new StreamReader (GlobalConstant.destination + "output.out");
				Output = participant_output.ReadToEnd (); //Program's output

				return 0; // Program ran successfully
				
			}
			catch {
				Run.Close ();
				Run.Dispose ();
				return 1; // Couldn't run the program
			}
		}

		public void Delete_participant_file () {				
			try {

				File.Delete (GlobalConstant.destination + "a.out");
			
			} catch (Exception ex) {
				Console.WriteLine ("Error deleting: {0}", ex.Message);
			}
		}
	}

}
